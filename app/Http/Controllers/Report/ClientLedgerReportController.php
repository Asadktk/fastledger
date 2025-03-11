<?php

namespace App\Http\Controllers\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use App\DataTables\FileOpeningReport;
use App\Models\File;
use App\Models\Client;
use App\Models\Transaction;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Vtiful\Kernel\Format;
class ClientLedgerReportController extends Controller
{
    public function index(){
        return view('admin.reports.clientLedger');
    }
    public function getdata(Request $request)
    {
        $File_id = $request->input('File_id');
        $ledger_ref = $request->input('ledger_ref');
        $userClientId = Auth::user()->Client_ID;
    
        // Get client details
        $client_data = Client::where('Client_ID', $userClientId)->first();
    
        $Client_Ref = $client_data->Client_Ref ?? 'N/A';
    
        // Get file details
        $file_data = File::where('Ledger_Ref', $ledger_ref)
                         ->where('File_id', $File_id)
                         ->first();
    
        // Get transactions where VAT_ID is empty or null
        $transection_data = Transaction::where('File_ID', $File_id)
            
            ->get();
    
        $client_balance = 0;
        $office_balance = 0;
        $results = [];
    
        foreach ($transection_data as $transaction) {
            $TransactionDate = Carbon::parse($transaction->Transaction_Date)->format('d/m/Y'); // Date Formatting
            $description = $transaction->Description;
            $Cheque = $transaction->Cheque;
    
            $client_Credit = 0;
            $client_Debit = 0;
            $office_Credit = 0;
            $office_Debit = 0;
    
            if ($transaction->Bank_Account_ID == 22 && $transaction->Is_Imported == 1) {
                if ($transaction->Paid_In_Out == 1) {
                    $client_Credit = $transaction->Amount;
                    $client_balance += $transaction->Amount;

                } elseif ($transaction->Paid_In_Out == 2) {
                    $client_Debit = $transaction->Amount;
                    $client_balance -= $transaction->Amount;
                }
            }
    
            if ($transaction->Bank_Account_ID == 23 && $transaction->Is_Imported == 1) {
                if ($transaction->Paid_In_Out == 1) {
                    $office_Credit = $transaction->Amount;
                    $office_balance += $transaction->Amount;
                } elseif ($transaction->Paid_In_Out == 2) {
                    $office_Debit = $transaction->Amount;
                    $office_balance -= $transaction->Amount;
                }
            }
    
            $row = [
                'TransactionDate' => $TransactionDate,
                'Description' => $description,
                'Cheque' => $Cheque,
                'Client_Debit' => $client_Debit,
                'Client_Credit' => $client_Credit,
                'Client_Balance' => $client_balance,
                'Office_Debit' => $office_Debit,
                'Office_Credit' => $office_Credit,
                'Office_Balance' => $office_balance,
            ];
    
            $results[] = $row;
        }
    
        return response()->json([
            'Client_Ref' => $Client_Ref,
            
            'file_data' => $file_data,
            'transactions' => $results,
        ]);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        $userClientId = Auth::user()->Client_ID;
    
        $file_data = File::where('Ledger_Ref', 'like', "%{$query}%")
                         ->where('Client_ID', $userClientId)
                         ->limit(10)
                         ->get();
    
        $fileSummaries = [];
    
        foreach ($file_data as $data) {
            $fileSummaries[] = [
                'file_id' => $data->File_ID,
                'Ledger_Ref' => $data->Ledger_Ref,
            ];
        }
    
        return response()->json($fileSummaries);
    }
  
}
