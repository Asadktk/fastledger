<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BankAccountType;
use App\DataTables\ClientCashBookDataTable;

class ClientCashBookController extends Controller
{
    public function index(ClientCashBookDataTable $dataTable)
    {
        $clientId = auth()->user()->Client_ID;

        // Fetch the banks for the client
        $banks = $this->getClientBanks($clientId, config('constants.CLIENT_BANK_TYPE_ID'));

        // Pass the banks to the view
        return $dataTable->render('admin.reports.client_cash_book', compact('banks'));
    }

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
