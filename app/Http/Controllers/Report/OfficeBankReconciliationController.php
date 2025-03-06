<?php

namespace App\Http\Controllers\Report;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class OfficeBankReconciliationController extends Controller
{

    public function index()
    {
        // Get the logged-in user's Client_ID
        $clientId = Auth::user()->Client_ID;

        // Fetch bank accounts related to the client
        $banks = BankAccount::where('client_id', $clientId)
            ->where('Bank_Type_ID', 2)
            ->get();

        return view('admin.reports.office-bank-reconciliation', compact('banks'));
    }


    public function getData(Request $request)
    {
        $clientId = Auth::user()->Client_ID;
        $bankId = $request->input('bank_account_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Validate inputs
        if (!$bankId || !$fromDate || !$toDate) {
            return response()->json(['error' => 'Invalid input parameters'], 400);
        }

        // Execute query
        $transactions = DB::select("
        SELECT 
            file.File_ID, 
            file.Ledger_Ref, 
            transaction.Transaction_ID,
            SUM(transaction.Amount) AS Amount,
            transaction.Cheque,
            transaction.Paid_In_Out,
            CONCAT(file.First_Name, ' ' ,file.Last_Name) AS Client_Name,
            AccountRef.Reference AS AccountRefDescription,
            transaction.Account_Ref_ID,
            AccountRef.Base_Category_ID
        FROM 
            File file 
        INNER JOIN 
            Transaction transaction ON file.File_ID = transaction.File_ID
        INNER JOIN 
            AccountRef ON transaction.Account_Ref_ID = AccountRef.Account_Ref_ID
        WHERE 
            Date(transaction.Transaction_Date) BETWEEN ? AND ?
            AND transaction.Is_Imported = 1
            AND transaction.Bank_Account_ID = ?
            AND file.Client_ID = ?
            AND (
                transaction.Account_Ref_ID IN (93, 86) 
                OR transaction.Account_Ref_ID IN (102, 95, 87)
                OR transaction.Account_Ref_ID IN (2, 100, 96)
                OR transaction.Account_Ref_ID IN (40, 108)  -- Moved this up for clarity
                OR AccountRef.Base_Category_ID = 7
                OR transaction.Account_Ref_ID IN (103, 106, 109, 105)
                OR AccountRef.Base_Category_ID = 5
            )
        GROUP BY 
            transaction.Transaction_ID, file.File_ID, file.Ledger_Ref, 
            transaction.Cheque, transaction.Paid_In_Out, Client_Name, 
            AccountRefDescription, transaction.Account_Ref_ID, AccountRef.Base_Category_ID
    ", [$fromDate, $toDate, $bankId, $clientId]);

        // Initialize categorized arrays
        $bookledger = [];
        $disbursments = [];
        $salesBook = [];
        $paymentRefund = [];
        $paymentTransfer = [];
        $miscellaneous = [];

        // Categorize transactions
        foreach ($transactions as $transaction) {
            if (in_array($transaction->Account_Ref_ID, [93, 86])) {
                $bookledger[] = $transaction;
            } elseif (in_array($transaction->Account_Ref_ID, [102, 95, 87])) {
                $disbursments[] = $transaction;
            } elseif (in_array($transaction->Account_Ref_ID, [2, 100, 96])) {
                $salesBook[] = $transaction;
            } elseif ($transaction->Base_Category_ID == 7 || in_array($transaction->Account_Ref_ID, [40, 108])) {
                $paymentRefund[] = $transaction;
            } elseif (in_array($transaction->Account_Ref_ID, [103, 106, 109, 105])) {
                $paymentTransfer[] = $transaction;
            } elseif ($transaction->Base_Category_ID == 5) {
                $miscellaneous[] = $transaction;
            }
        }
        return response()->json([
            'book_ledger' => $bookledger,
            'disbursments' => $disbursments,
            'sales_book' => $salesBook,
            'payment_refund' => $paymentRefund,
            'payment_transfer' => $paymentTransfer,
            'miscellaneous' => $miscellaneous,
        ]);
    }
}
