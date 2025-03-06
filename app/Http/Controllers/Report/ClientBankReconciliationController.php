<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientBankReconciliationController extends Controller
{
    public function index()
    {
        $date = now()->format('Y-m-d'); // Default to current date
        $client_id = Auth::user()->Client_ID;

        // Fetch initial data (Client Balance and Office Balance)
        $finalResult = $this->fetchBankReconciliationData($client_id, $date);

        // Return the view with initial data
        return view('admin.reports.client_bank_reconciliation', ['resultSet' => $finalResult]);
    }

    // Fetch Bank Reconciliation Data for a given date
   
    public function fetchBankReconciliation($date)
    {
        $client_id = Auth::user()->Client_ID;
        $finalResult = $this->fetchBankReconciliationData($client_id, $date);

        return response()->json($finalResult);
    }

    // Reusable method to fetch client & office balances
    private function fetchBankReconciliationData($client_id, $date)
    {
        try {
            // Fetch Client Balance (Bank_Type_ID = 1)
            $clientBalanceQuery = DB::table('File as file')
                ->join('Transaction as transaction', 'file.File_ID', '=', 'transaction.File_ID')
                ->join('BankAccount as BankAccount', 'BankAccount.Bank_Account_ID', '=', 'transaction.Bank_Account_ID')
                ->select(
                    'file.File_ID',
                    'file.Ledger_Ref',
                    DB::raw(
                        "SUM(
                            CASE
                                WHEN transaction.paid_in_out = 1 AND BankAccount.Bank_Type_ID = 1 THEN transaction.Amount
                                WHEN transaction.paid_in_out = 2 AND BankAccount.Bank_Type_ID = 1 THEN -transaction.Amount
                                ELSE 0
                            END
                        ) as `Client Balance`"
                    ),
                    DB::raw("CONCAT(file.First_Name, ' ', file.Last_Name) as Client_Name")
                )
                ->whereDate('transaction.Transaction_Date', '<=', $date)
                ->where('transaction.Is_Imported', 1)
                ->where('BankAccount.Bank_Type_ID', 1)  // Client Bank Accounts
                ->where('file.Client_ID', $client_id)
                ->groupBy('file.File_ID', 'file.Ledger_Ref', 'file.First_Name', 'file.Last_Name');

            // Fetch Office Balance (Bank_Type_ID = 2)
            $officeBalanceQuery = DB::table('File as file')
                ->join('Transaction as transaction', 'file.File_ID', '=', 'transaction.File_ID')
                ->join('BankAccount as BankAccount', 'BankAccount.Bank_Account_ID', '=', 'transaction.Bank_Account_ID')
                ->select(
                    'file.File_ID',
                    'file.Ledger_Ref',
                    DB::raw(
                        "SUM(
                            CASE
                                WHEN transaction.paid_in_out = 1 AND BankAccount.Bank_Type_ID = 2 THEN transaction.Amount
                                WHEN transaction.paid_in_out = 2 AND BankAccount.Bank_Type_ID = 2 THEN -transaction.Amount
                                ELSE 0
                            END
                        ) as `Office Balance`"
                    ),
                    DB::raw("CONCAT(file.First_Name, ' ', file.Last_Name) as Client_Name")
                )
                ->whereDate('transaction.Transaction_Date', '<=', $date)
                ->where('transaction.Is_Imported', 1)
                ->where('BankAccount.Bank_Type_ID', 2)  // Office Bank Accounts
                ->where('file.Client_ID', $client_id)
                ->groupBy('file.File_ID', 'file.Ledger_Ref', 'file.First_Name', 'file.Last_Name');

            // Get results
            $clientBalances = $clientBalanceQuery->get();
            $officeBalances = $officeBalanceQuery->get();

            // Combine results
            return $clientBalances->map(function ($clientBalance) use ($officeBalances) {
                $officeBalance = $officeBalances->firstWhere('File_ID', $clientBalance->File_ID);
                $clientBalance->Office_Balance = isset($officeBalance) ? $officeBalance->{'Office Balance'} : '0.00';

                return $clientBalance;
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data: ' . $e->getMessage()], 500);
        }
    }

    public function exportPdf($date)
    {
        $client_id = Auth::user()->Client_ID;
        $finalResult = $this->fetchBankReconciliationData($client_id, $date);

        // Load view and pass data
        $pdf = Pdf::loadView('admin.reports.pdf.client_bank_reconciliation_pdf', ['resultSet' => $finalResult]);

        // Return as a download
        return $pdf->download('client_bank_reconciliation_' . $date . '.pdf');
    }
}
