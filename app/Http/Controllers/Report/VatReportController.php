<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VatReportController extends Controller
{

    public function index(Request $request)
    {
        $clientId = auth()->user()->Client_ID ?? $request->input('client_id');
        $clientInfo = Client::find($clientId);

        $dateFrom = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->toDateString() : null;
        $dateTo = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->toDateString() : null;

        // Fetch necessary amounts
        $amountBox1 = $this->getVatAmountBox1($dateFrom, $dateTo, $clientId);
        $incomeHead = $this->getVatIncomeHead($dateFrom, $dateTo, $clientId);
        $costOfSale = $this->getVATCostOfSale($dateFrom, $dateTo, $clientId);
        $expenses = $this->getVATExpense($dateFrom, $dateTo, $clientId);


        // dd($amountBox1, $incomeHead, $costOfSale, $expenses);
        // Initialize boxes
        $_box1Amount = 0;
        $_box6Amount = 0;
        $_box4Amount = 0;
        $_box7Amount = 0;
        $_costOfSaleTotal = 0.00;
        $_expenseTotal = 0.00;


        $outputVatDetails = [];
        $costOfSaleDetails = [];
        $expenseDetails = [];


        // Process Cost of Sale
        foreach ($costOfSale as $value) {
            list($net, $vat) = $this->calculateVat($value->Amount, $value->Percentage);

            $_box7Amount += $net; // total net
            $_box4Amount += $vat; // total vat (purchases VAT)
            $_costOfSaleTotal += $net + $vat;

            $costOfSaleDetails[] = [
                'date' => $value->Date ?? '',
                'ledger_ref' => $value->Ledger_Ref ?? '',
                'account_ref' => $value->Account_Ref ?? '',
                'description' => $value->Description ?? '',
                'net' => $net,
                'vat' => $vat,
                'gross' => $net + $vat,
                'rate' => $value->Percentage ? $value->Percentage . '%' : '-',

            ];
        }



        foreach ($incomeHead as $value) {
            list($net, $vat) = $this->calculateVat($value->Amount, $value->Percentage);

            $_box6Amount += $net; // total net
            $_box1Amount += $vat; // total vat

            $outputVatDetails[] = [
                'date' => $value->Date ?? '',
                'ledger_ref' => $value->Ledger_Ref ?? '',
                'account_ref' => $value->Account_Ref ?? '',
                'description' => $value->Description ?? '',
                'net' => $net,
                'vat' => $vat,
                'rate' => $value->Percentage ? $value->Percentage . '%' : '-',
            ];
        }


        foreach ($expenses as $value) {
            list($net, $vat) = $this->calculateVat($value->Amount, $value->Percentage);

            $_box7Amount += $net; // adding net to purchases total
            $_box4Amount += $vat; // adding vat to purchases VAT
            $_expenseTotal += $net + $vat;

            $expenseDetails[] = [
                'date' => $value->Date ?? '',
                'ledger_ref' => $value->Ledger_Ref ?? '',
                'account_ref' => $value->Account_Ref ?? '',
                'description' => $value->Description ?? '',
                'net' => $net,
                'vat' => $vat,
                'gross' => $net + $vat,
                'rate' => $value->Percentage ? $value->Percentage . '%' : '-',

            ];
        }

        // // You can also calculate other totals if necessary, like incoming VAT:
        // $totalIncomingNet = $_box7Amount;  // Adjust according to your logic
        // $totalIncomingVat = $_expenseTotal;




        // // Calculate total output net
        // $totalOutputNet = $_box1Amount + $_box6Amount;  // Adjust according to your logic
        // $totalOutputVat = $_box1Amount;  // Adjust according to your logic

        // // You can also calculate other totals if necessary, like incoming VAT:
        // $totalIncomingNet = $_box7Amount;  // Adjust according to your logic
        // $totalIncomingVat = $_expenseTotal;


        // Return view with data
        return view('admin.reports.vat_report', [
            'outputVatDetails' => $outputVatDetails,
            'clientInfo' => $clientInfo,
            'amountBox1' => $amountBox1,
            '_box1Amount' => $_box1Amount,
            '_box6Amount' => $_box6Amount,
            '_box4Amount' => $_box4Amount,
            '_box7Amount' => $_box7Amount,
            '_costOfSaleTotal' => $_costOfSaleTotal,
            '_expenseTotal' => $_expenseTotal,
            'outputVatDetails' => $outputVatDetails,
            'costOfSaleDetails' => $costOfSaleDetails,
            'expenseDetails' => $expenseDetails,
            // 'totalOutputNet' => $totalOutputNet,
            // 'totalOutputVat' => $totalOutputVat,
            // 'totalIncomingNet' => $totalIncomingNet,
            // 'totalIncomingVat' => $totalIncomingVat,
            'fromDate' => $request->input('from_date'),
            'toDate' => $request->input('to_date'),
        ]);
    }


    private function calculateVat($amount, $percentage)
    {
        $net = $amount;
        $vat = 0;

        if ($percentage == 20) {
            $net = ($amount * 5) / 6;
        } elseif ($percentage == 5) {
            $net = ($amount * 20) / 21;
        }

        $vat = $amount - $net;
        return [$net, $vat];
    }



    public function getVatAmountBox1($date_from, $date_to, $clientId)
    {
        return Transaction::join('File as file', 'file.File_ID', '=', 'Transaction.File_ID')
            ->where('Transaction.Is_Imported', 1)
            ->where('file.Client_ID', $clientId)
            ->whereIn('Transaction.Account_Ref_ID', [101, 99])
            ->whereBetween('Transaction.Transaction_Date', [$date_from, $date_to])
            ->sum('Transaction.Amount');
    }


    public function getVATExpense($date_from, $date_to, $clientId)
    {
        return Transaction::selectRaw('
            MAX(transaction.Transaction_ID) as Transaction_ID,
            MAX(transaction.Transaction_Date) as Transaction_Date,
            MAX(transaction.File_ID) as File_ID,
            MAX(transaction.Bank_Account_ID) as Bank_Account_ID,
            MAX(transaction.Paid_In_Out) as Paid_In_Out,
            MAX(transaction.Payment_Type_ID) as Payment_Type_ID,
            MAX(file.Ledger_Ref) as Ledger_Ref,
            MAX(vatType.Percentage) as Percentage,
            MAX(transaction.Description) as Description,
            MAX(accountRef.Reference) as Reference,
            SUM(transaction.Amount) as Amount
        ')
            ->join('file', 'file.File_ID', '=', 'transaction.File_ID')
            ->leftJoin('vatType', 'vatType.VAT_ID', '=', 'transaction.VAT_ID')
            ->join('accountRef', 'accountRef.Account_Ref_ID', '=', 'transaction.Account_Ref_ID')
            ->where('transaction.Is_Imported', 1)
            ->whereHas('file', function ($query) use ($clientId) {
                $query->where('Client_ID', $clientId);
            })
            ->whereHas('accountRef', function ($query) {
                $query->where('Base_Category_ID', 7); // Expense category
            })
            ->whereBetween('transaction.Transaction_Date', [$date_from, $date_to])
            ->groupBy('transaction.Transaction_ID', 'transaction.Transaction_Date', 'transaction.File_ID', 'transaction.Bank_Account_ID', 'transaction.Paid_In_Out')
            ->get();
    }

    public function getVATCostOfSale($date_from, $date_to, $clientId)
    {
        return Transaction::selectRaw('
        MAX(transaction.Transaction_ID) as Transaction_ID,
        MAX(transaction.Transaction_Date) as Transaction_Date,
        MAX(transaction.File_ID) as File_ID,
        MAX(transaction.Bank_Account_ID) as Bank_Account_ID,
        MAX(transaction.Paid_In_Out) as Paid_In_Out,
        MAX(transaction.Payment_Type_ID) as Payment_Type_ID,
        MAX(file.Ledger_Ref) as Ledger_Ref,
        MAX(vatType.Percentage) as Percentage,
        MAX(transaction.Description) as Description,
        MAX(accountRef.Reference) as Reference,
        SUM(transaction.Amount) as Amount
    ')
            ->join('file', 'file.File_ID', '=', 'transaction.File_ID')
            ->leftJoin('vatType', 'vatType.VAT_ID', '=', 'transaction.VAT_ID')
            ->join('accountRef', 'accountRef.Account_Ref_ID', '=', 'transaction.Account_Ref_ID')
            ->where('transaction.Is_Imported', 1)
            ->whereHas('file', function ($query) use ($clientId) {
                $query->where('Client_ID', $clientId);
            })
            ->whereIn('transaction.Account_Ref_ID', [108, 6, 7]) // Cost of sale accounts
            ->whereBetween('transaction.Transaction_Date', [$date_from, $date_to])
            ->groupBy('transaction.Transaction_ID', 'transaction.Transaction_Date', 'transaction.File_ID', 'transaction.Bank_Account_ID', 'transaction.Paid_In_Out')
            ->get();
    }


    public function getVatIncomeHead($date_from, $date_to, $clientId)
    {
        return Transaction::selectRaw('
            MAX(transaction.Transaction_ID) as Transaction_ID,
            MAX(transaction.Transaction_Date) as Transaction_Date,
            MAX(transaction.File_ID) as File_ID,
            MAX(transaction.Bank_Account_ID) as Bank_Account_ID,
            MAX(transaction.Paid_In_Out) as Paid_In_Out,
            MAX(transaction.Payment_Type_ID) as Payment_Type_ID,
            MAX(file.Ledger_Ref) as Ledger_Ref,
            MAX(vatType.Percentage) as Percentage,
            MAX(transaction.Description) as Description,
            MAX(accountRef.Reference) as Reference,
            SUM(transaction.Amount) as Amount
        ')
            ->join('file', 'file.File_ID', '=', 'transaction.File_ID')
            ->leftJoin('vatType', 'vatType.VAT_ID', '=', 'transaction.VAT_ID')
            ->join('accountRef', 'accountRef.Account_Ref_ID', '=', 'transaction.Account_Ref_ID')
            ->where('transaction.Is_Imported', 1)
            ->whereHas('file', function ($query) use ($clientId) {
                $query->where('Client_ID', $clientId);
            })
            ->whereIn('transaction.Account_Ref_ID', [101, 99])
            ->whereBetween('transaction.Transaction_Date', [$date_from, $date_to])
            ->groupBy('transaction.Transaction_ID', 'transaction.Transaction_Date', 'transaction.File_ID', 'transaction.Bank_Account_ID', 'transaction.Paid_In_Out')
            ->get();
    }
}
