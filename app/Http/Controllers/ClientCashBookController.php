<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\ClientCashBookDataTable;

class ClientCashBookController extends Controller
{
    // Method to display the Client Cash Book page
    public function index(ClientCashBookDataTable $dataTable)
    {
        $clientId = auth()->user()->Client_ID;

        // Fetch the banks for the client
        $banks = $this->getClientBanks($clientId, config('constants.CLIENT_BANK_TYPE_ID'));

        // Check if filters are applied
        $hasFilter = request()->filled('bank_account_id')
            || (request()->filled('from_date') && request()->filled('to_date'));

        $initialBalance = 0;

        // Calculate the initial balance based on transactions before the 'from_date' (if filter is applied)
        if ($hasFilter) {
            $initialBalanceQuery = Transaction::join('File', 'File.File_ID', '=', 'Transaction.File_ID')
                ->whereNull('Transaction.Deleted_On')
                ->where('Transaction.Is_Imported', 1)
                ->where('Transaction.Is_Bill', 0)
                ->where('File.Client_ID', $clientId)
                ->when(request()->filled('bank_account_id'), function ($q) {
                    $q->where('Transaction.Bank_Account_ID', request('bank_account_id'));
                })
                ->when(request()->filled('from_date'), function ($q) {
                    $q->where('Transaction.Transaction_Date', '<', request('from_date')); // Transactions before 'from_date'
                });

            // Calculate the initial balance as the sum of all transactions before the selected date
            $initialBalance = $initialBalanceQuery->sum(DB::raw("CASE WHEN Transaction.Paid_In_Out = 1 THEN Transaction.Amount ELSE -Transaction.Amount END"));
            $initialBalance = $initialBalance === null ? 0 : $initialBalance;
        }

        // Pass the banks and initial balance to the view
        return $dataTable->render('admin.reports.client_cash_book', compact('banks', 'initialBalance'));
    }

    // Method to fetch updated initial balance via AJAX
    public function getInitialBalance(Request $request)
    {
        $clientId = auth()->user()->Client_ID;
        $initialBalance = 0;

        // Check if filters are applied
        $hasFilter = $request->filled('bank_account_id')
            || ($request->filled('from_date') && $request->filled('to_date'));

        if ($hasFilter) {
            $initialBalanceQuery = Transaction::join('File', 'File.File_ID', '=', 'Transaction.File_ID')
                ->whereNull('Transaction.Deleted_On')
                ->where('Transaction.Is_Imported', 1)
                ->where('Transaction.Is_Bill', 0)
                ->where('File.Client_ID', $clientId)
                ->when($request->filled('bank_account_id'), function ($q) use ($request) {
                    $q->where('Transaction.Bank_Account_ID', $request->input('bank_account_id'));
                })
                ->when($request->filled('from_date'), function ($q) use ($request) {
                    $q->where('Transaction.Transaction_Date', '<', $request->input('from_date'));
                });

            // Calculate the initial balance as the sum of all transactions before the selected date
            $initialBalance = $initialBalanceQuery->sum(DB::raw("CASE WHEN Transaction.Paid_In_Out = 1 THEN Transaction.Amount ELSE -Transaction.Amount END"));
            $initialBalance = $initialBalance === null ? 0 : $initialBalance;
        }

        // Return the updated initial balance as JSON response
        return response()->json(['initial_balance' => number_format($initialBalance, 2)]);
    }

    // Helper function to fetch client banks
    public function getClientBanks($clientId, $bankTypeId = null)
    {
        $query = BankAccount::join('BankAccountType', 'BankAccount.Bank_Type_ID', '=', 'BankAccountType.Bank_Type_ID')
            ->where('BankAccount.Client_ID', $clientId)
            ->orderBy('BankAccount.Bank_Name', 'asc');

        if (!is_null($bankTypeId)) {
            $query->where('BankAccount.Bank_Type_ID', $bankTypeId);
        }

        $banks = $query->get([
            'BankAccount.Bank_Account_ID',
            'BankAccount.Bank_Name',
            'BankAccountType.Bank_Type',
            'BankAccount.Bank_Type_ID',
        ]);

        return $banks->map(function ($bank) {
            return [
                'Bank_Account_ID' => $bank->Bank_Account_ID,
                'Bank_Account_Name' => "{$bank->Bank_Name} ({$bank->Bank_Type})",
                'Bank_Type_ID' => $bank->Bank_Type_ID,
            ];
        });
    }
}
