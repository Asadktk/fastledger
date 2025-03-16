<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ClientCashBookDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'clientcashbook.action')
            ->setRowId('id');
    }

    public function query(Transaction $model): QueryBuilder
    {
        // Check if filters are applied
        $hasFilter = request()->filled('client_id')
            || request()->filled('bank_account_id')
            || (request()->filled('from_date') && request()->filled('to_date'));

        // If no filters, return a query that doesn't match any records
        if (!$hasFilter) {
            return $model->newQuery()->whereRaw('1=0');
        }

        // Get the logged-in user's client ID
        $clientId = auth()->user()->Client_ID;

        // Calculate the initial balance (before the selected date range)
        $initialBalanceQuery = $model->newQuery()
            ->join('File', 'File.File_ID', '=', 'Transaction.File_ID')
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

        // Sum the initial balance (considering both Payments and Receipts)
        $initialBalance = $initialBalanceQuery->sum(DB::raw("CASE WHEN Transaction.Paid_In_Out = 1 THEN Transaction.Amount ELSE -Transaction.Amount END"));
        $initialBalance = $initialBalance === null ? 0 : $initialBalance;

        // Base query for transactions
        $query = $model->newQuery()
            ->join('File', 'File.File_ID', '=', 'Transaction.File_ID')
            ->join('BankAccount', 'BankAccount.Bank_Account_ID', '=', 'Transaction.Bank_Account_ID')
            ->join('PaymentType', 'PaymentType.Payment_Type_ID', '=', 'Transaction.Payment_Type_ID')
            ->leftJoin('AccountRef', 'AccountRef.Account_Ref_ID', '=', 'Transaction.Account_Ref_ID')
            ->whereNull('Transaction.Deleted_On')
            ->where('Transaction.Is_Imported', 1)
            ->where('Transaction.Is_Bill', 0)
            ->where('File.Client_ID', $clientId)
            ->when(request()->filled('bank_account_id'), function ($q) {
                $q->where('Transaction.Bank_Account_ID', request('bank_account_id'));
            });

        // Define the query when filters are set for the date range
        $query->when(request()->filled('from_date') && request()->filled('to_date'), function ($q) use ($initialBalance) {
            $q->whereBetween('Transaction.Transaction_Date', [request('from_date'), request('to_date')])
                ->select([
                    'Transaction.Transaction_ID',
                    'Transaction.Transaction_Date',
                    'File.Ledger_Ref',
                    'Transaction.Amount',
                    'BankAccount.Bank_Name as Bank_Account_Name',
                    'BankAccount.Account_No as Account_No',
                    'BankAccount.Sort_Code as Sort_Code',
                    'PaymentType.Payment_Type_Name',
                    'AccountRef.Reference as Account_Ref',
                    'Transaction.Description',
                    'Transaction.Cheque',
                    DB::raw("CASE WHEN Transaction.Paid_In_Out = 2 THEN Transaction.Amount ELSE 0 END AS Payments"),
                    DB::raw("CASE WHEN Transaction.Paid_In_Out = 1 THEN Transaction.Amount ELSE 0 END AS Receipts"),
                    // Adjust the balance calculation to account for debits and credits correctly
                    DB::raw("SUM(CASE
                    WHEN Transaction.Paid_In_Out = 1 THEN Transaction.Amount
                    WHEN Transaction.Paid_In_Out = 2 THEN -Transaction.Amount
                    ELSE 0
                END) OVER (ORDER BY Transaction.Transaction_Date ASC ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) + $initialBalance AS Balance"),


                    DB::raw("IF(Transaction.Cheque IS NOT NULL AND Transaction.Cheque != '', 'CHQ', '') AS Transaction_Type"),
                    // Modify the initial balance to be 0 or positive
                    DB::raw("GREATEST(0, $initialBalance) AS initial_Balance"), // This ensures initial balance is never negative
                ]);
        });

        // Return the ordered query

        return $query->orderBy('Transaction.Transaction_Date', 'asc');
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clientcashbook-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            'Transaction_Date' => ['title' => 'DATE'],
            'Transaction_Type' => ['title' => 'TRANS TYPE', 'orderable' => false],
            'Cheque' => ['title' => 'CHQ NO PAY IN'],
            'Description' => ['title' => 'DESCRIPTION'],
            'Account_Ref' => ['title' => 'Account Ref'],
            'Ledger_Ref' => ['title' => 'LEDGER REF'],
            'Payments' => ['title' => 'PAYMENTS (DR)'],
            'Receipts' => ['title' => 'RECEIPTS (CR)'],
            'Balance' => ['title' => 'BALANCE'],
            // 'initial_Balance' => ['title' => 'INITIAL BALANCE'],
        ];
    }


    protected function filename(): string
    {
        return 'ClientCashBook_' . date('YmdHis');
    }
}
