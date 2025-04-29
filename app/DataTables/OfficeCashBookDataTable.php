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

class OfficeCashBookDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'officecashbook.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
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

        // Get the logged-in user's client ID (for office-based logic, adjust as needed)
        $clientId = auth()->user()->Client_ID; // Assuming Client_ID is used to filter for office-related transactions.

        // Calculate the initial balance (before the selected date range)
        $initialBalanceQuery = $model->newQuery()
            ->join('file', 'file.File_ID', '=', 'transaction.File_ID')
            ->whereNull('transaction.Deleted_On')
            ->where('transaction.Is_Imported', 1)
            ->where('transaction.Is_Bill', 0)
            ->where('file.Client_ID', $clientId)  // Using Client_ID here
            ->when(request()->filled('bank_account_id'), function ($q) {
                $q->where('transaction.Bank_Account_ID', request('bank_account_id'));
            })
            ->when(request()->filled('from_date'), function ($q) {
                $q->where('transaction.Transaction_Date', '<', request('from_date')); // Transactions before 'from_date'
            });

        // Sum the initial balance (considering both Payments and Receipts)
        $initialBalance = $initialBalanceQuery->sum(DB::raw("CASE WHEN transaction.Paid_In_Out = 1 THEN transaction.Amount ELSE -transaction.Amount END"));
        $initialBalance = $initialBalance === null ? 0 : $initialBalance;

        // Base query for transactions
        $query = $model->newQuery()
            ->join('file', 'file.File_ID', '=', 'transaction.File_ID')
            ->join('bankaccount', 'bankaccount.Bank_Account_ID', '=', 'transaction.Bank_Account_ID')
            ->join('paymenttype', 'paymenttype.Payment_Type_ID', '=', 'transaction.Payment_Type_ID')
            ->leftJoin('accountref', 'accountref.Account_Ref_ID', '=', 'transaction.Account_Ref_ID')
            ->whereNull('transaction.Deleted_On')
            ->where('transaction.Is_Imported', 1)
            ->where('transaction.Is_Bill', 0)
            ->where('file.Client_ID', $clientId)  // Using Client_ID for office-related filtering
            ->when(request()->filled('bank_account_id'), function ($q) {
                $q->where('transaction.Bank_Account_ID', request('bank_account_id'));
            });

        // Define the query when filters are set for the date range
        $query->when(request()->filled('from_date') && request()->filled('to_date'), function ($q) use ($initialBalance) {
            $q->whereBetween('transaction.Transaction_Date', [request('from_date'), request('to_date')])
                ->select([
                    'transaction.Transaction_ID',
                    'transaction.Transaction_Date',
                    'file.Ledger_Ref',
                    'transaction.Amount',
                    'bankaccount.Bank_Name as Bank_Account_Name',
                    'paymenttype.Payment_Type_Name',
                    'accountref.Reference as Account_Ref',
                    'transaction.Description',
                    'transaction.Cheque',
                    DB::raw("CASE WHEN transaction.Paid_In_Out = 2 THEN transaction.Amount ELSE 0 END AS Payments"),
                    DB::raw("CASE WHEN transaction.Paid_In_Out = 1 THEN transaction.Amount ELSE 0 END AS Receipts"),
                    // Adjust the balance calculation to account for debits and credits correctly
                    DB::raw("SUM(CASE
                    WHEN transaction.Paid_In_Out = 1 THEN transaction.Amount
                    WHEN transaction.Paid_In_Out = 2 THEN -transaction.Amount
                    ELSE 0
                END) OVER (ORDER BY transaction.Transaction_Date ASC ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW) + $initialBalance AS Balance"),

                    DB::raw("IF(transaction.Cheque IS NOT NULL AND transaction.Cheque != '', 'CHQ', '') AS Transaction_Type"),
                    // Modify the initial balance to be 0 or positive
                    DB::raw("GREATEST(0, $initialBalance) AS initial_Balance"), // This ensures initial balance is never negative
                ]);
        });

        // Return the ordered query
        return $query->orderBy('transaction.Transaction_Date', 'asc');
    }


    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('officecashbook-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
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

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'OfficeCashBook_' . date('YmdHis');
    }
}