<?php

namespace App\DataTables;

use App\Models\DayBook;
use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DayBookDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('Bank_Account_Name', function ($row) {
                if ($row->bankAccount) {
                    $accountName = $row->bankAccount->Account_Name ?? 'N/A';
                    $bankType = $row->bankAccount->bankAccountType->Bank_Type ?? 'N/A'; 
                    return $accountName . ' (' . $bankType . ')'; 
                }
                return 'N/A';
            })
            ->addColumn('Reference', function ($row) {
                return $row->accountRef ? $row->accountRef->Reference : 'N/A';
            })
            ->addColumn('Payment_Type_Name', function ($row) {
                return $row->paymentType ? $row->paymentType->Payment_Type_Name : 'N/A';
            })
            ->addColumn('Net_Amount', function ($row) {
                // Check if vatType exists and has Percentage, otherwise use a default value
                $percentage = $row->vatType ? $row->vatType->Percentage : 0;
                $netVat = $this->calculateNetAmount($row->Amount, $percentage);
                return $netVat['net'];
            })
            ->addColumn('Vat_Amount', function ($row) {
                // Check if vatType exists and has Percentage, otherwise use a default value
                $percentage = $row->vatType ? $row->vatType->Percentage : 0;
                $netVat = $this->calculateNetAmount($row->Amount, $percentage);
                return $netVat['vat'];
            })
            ->addColumn('Is_Imported', function ($row) {
                return '<a href="' . route('transactions.import', $row->Transaction_ID) . '" 
                           class="btn btn-sm btn-success">Import</a>';
            })
            ->addColumn('action', 'transaction.action')
            ->setRowId('Transaction_ID')
            ->rawColumns(['Is_Imported', 'action']);;
    }

    /**
     * Calculate Net Amount and VAT.
     */
    private function calculateNetAmount($amount, $percentage)
    {
        $netAmount = $amount;
        if ($percentage == 20) {
            $netAmount = ($amount * 5) / 6;
        } elseif ($percentage == 5) {
            $netAmount = ($amount * 20) / 21;
        }
        $vatAmount = $amount - $netAmount;

        return [
            'net' => $netAmount,
            'vat' => $vatAmount,
        ];
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Transaction $model): QueryBuilder
    {
        $clientId = auth()->user()->Client_ID;
        $userRole = auth()->user()->Role;
        $userRoleId = $userRole ? $userRole->Role_ID : null;
        $userId = null;

        if ($userRoleId == 3) {
            $userId = auth()->id();
        }

        // Base query to fetch transactions
        $query = $model->newQuery()
            ->with([
                'file.client',
                'bankAccount.bankAccountType',
                'paymentType',
                'accountRef',
                'vatType',
            ])
            ->whereHas('file.client', function ($query) use ($clientId) {
                $query->where('Client_ID', $clientId);
            })
            ->where('Is_Imported', 0)
            ->whereNull('transaction.Deleted_On')
            ->orderByDesc('Transaction_Date');

        // Filter based on net amount or VAT if provided in the request
        if ($amountActual = request('txtAmountActual')) {
            $query->whereRaw("FLOOR(Amount * 5 / 6) = ?", [$amountActual]); // Calculate net amount for 20% VAT
        }

        if ($amountNet = request('txtAmountNet')) {
            $query->whereRaw("FLOOR(Amount - (Amount * 5 / 6)) = ?", [$amountNet]); // Calculate VAT for 20% VAT
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('daybook-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->scrollX(true)
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
            Column::make('Transaction_Date')->title('Transaction Date'),
            Column::make('file.Ledger_Ref')->title('Ledger Ref'),
            Column::make('Bank_Account_Name')->title('Bank Account (Type)'),
            Column::make('Paid_In_Out')->title('Paid In/Out'),
            Column::make('Reference')->title('Reference'),
            Column::make('Payment_Type_Name')->title('Payment Type'),
            Column::computed('Net_Amount')->title('Net Amount'),
            Column::computed('Vat_Amount')->title('VAT Amount'),
            Column::computed('Is_Imported')
            ->width(60)
            ->addClass('text-center')
            ->title('Import'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DayBook_' . date('YmdHis');
    }
}
