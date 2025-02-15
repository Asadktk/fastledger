<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
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

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        // Start with the base query
        $query = $model->newQuery()
            ->join('File', 'File.File_ID', '=', 'Transaction.File_ID')
            ->join('BankAccount', 'BankAccount.Bank_Account_ID', '=', 'Transaction.Bank_Account_ID')
            ->join('PaymentType', 'PaymentType.Payment_Type_ID', '=', 'Transaction.Payment_Type_ID')
            ->leftJoin('AccountRef', 'AccountRef.Account_Ref_ID', '=', 'Transaction.Account_Ref_ID')
            ->select([
                'Transaction.Transaction_ID',
                'Transaction.Transaction_Date',
                'File.Ledger_Ref',
                'Transaction.Amount',
                'BankAccount.Bank_Name as Bank_Account_Name',
                'PaymentType.Payment_Type_Name',
                'AccountRef.Reference as Account_Ref',
                'Transaction.Description',
                'Transaction.Cheque',
                DB::raw("IF(Transaction.Amount > 0, 'Paid', 'Unpaid') AS Payments"),
                DB::raw("IF(Transaction.Amount < 0, ABS(Transaction.Amount), 0) AS Receipts"),
                DB::raw("(
                    SELECT SUM(t.Amount)
                    FROM Transaction t
                    WHERE t.File_ID = Transaction.File_ID
                    AND t.Transaction_Date <= Transaction.Transaction_Date
                ) AS Balance"),
                DB::raw("IF(Transaction.Cheque IS NOT NULL AND Transaction.Cheque != '', 'CHQ', '') AS Transaction_Type"),
            ])
            ->active()
            ->orderBy('Transaction.Transaction_Date', 'desc');

        // Apply date filters only if both values are provided
        if (request()->filled('from_date') && request()->filled('to_date')) {
            $query->whereBetween('Transaction.Transaction_Date', [
                request('from_date'),
                request('to_date'),
            ]);
        }

        // Apply bank name filter
        if (request()->filled('bank_name')) {
            $query->where('BankAccount.Bank_Name', 'like', '%' . request('bank_name') . '%');
        }
        if (request()->filled('bank_account_id')) {
            $query->where('Transaction.Bank_Account_ID', request('bank_account_id'));
        }

        return $query;
    }
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('clientcashbook-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            'Transaction_Date' => ['title' => 'DATE'],
            'Transaction_Type' => ['title' => 'TRANS TYPE'],
            'Cheque' => ['title' => 'CHQ NO PAY IN'],
            'Description' => ['title' => 'DESCRIPTION'],
            'Account_Ref' => ['title' => 'Account Ref'],
            'Ledger_Ref' => ['title' => 'LEDGER REF'],
            'Payments' => ['title' => 'PAYMENTS (DR)'],
            'Receipts' => ['title' => 'RECEIPTS (CR)'],
            'Balance' => ['title' => 'BALANCE'],
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ClientCashBook_' . date('YmdHis');
    }
}
