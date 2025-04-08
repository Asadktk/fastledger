<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\VatType;
use App\Models\AccountRef;
use App\Models\BankAccount;
use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\TransactionDataTable;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.transaction_report.transaction_report');
    }

    public function downloadtransactionpdf(Request $request)
    {
        $clientId = auth()->user()->Client_ID;
        $getclient=Client::where('Client_ID',$clientId)->first();
        $client_name=$getclient->Business_Name;

        $transactions = Transaction::with([
            'file.client',
            'bankAccount.bankAccountType',
            'paymentType',
            'accountRef',
            'vatType',
        ])
        ->whereHas('file.client', function ($query) use ($clientId) {
            $query->where('Client_ID', $clientId);
        })
        ->where('Is_Imported', 1)
        ->whereNull('Deleted_On')
        ->orderByDesc('Transaction_Date')
        ->get();

        $pdf = Pdf::loadView('admin.pdf.transactionpdf', compact('transactions', 'client_name'));
        return $pdf->download('daybook_report.pdf');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        try {
            $transaction->delete();
            return redirect()->back()->with('success', 'Transaction deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }
}
