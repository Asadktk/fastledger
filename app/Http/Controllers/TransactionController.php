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

class TransactionController extends Controller
{
    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.transaction_report.transaction_report');
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
