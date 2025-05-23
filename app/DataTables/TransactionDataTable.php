<?php

namespace App\DataTables;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TransactionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('Transaction_Date', function ($row) {
            return \Carbon\Carbon::parse($row->Transaction_Date)->format('Y-m-d'); // Display date only
        })
        ->addColumn('Paid_In_Out', function ($row) {
            return $row->Paid_In_Out == 1 ? 'Paid In' : ($row->Paid_In_Out == 2 ? 'Paid Out' : 'N/A'); // Map Paid In/Out
        })
            ->addColumn('Bank_Account_Name', function ($row) {
                if ($row->bankAccount) {
                    $accountName = $row->bankAccount->Account_Name ?? 'N/A';
                    $bankType = $row->bankAccount->bankAccountType->Bank_Type ?? 'N/A'; // Access Bank_Type
                    return $accountName . ' (' . $bankType . ')'; // Combine Account Name and Bank Type
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
                $percentage = $row->vatType ? $row->vatType->Percentage : 0;
                $netVat = $this->calculateNetAmount($row->Amount, $percentage);
                return number_format($netVat['net'], 2); // Round to two decimal places
            })
            ->addColumn('Vat_Amount', function ($row) {
                $percentage = $row->vatType ? $row->vatType->Percentage : 0;
                $netVat = $this->calculateNetAmount($row->Amount, $percentage);
                return number_format($netVat['vat'], 2); // Round to two decimal places
            })
            ->addColumn('action', function ($row) {
                return '
                    <form action="' . route('transactions.destroy', $row->Transaction_ID) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this transaction?\')">
                            Delete
                        </button>
                    </form>
                ';
            })
            ->setRowId('Transaction_ID');
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
            ->where('Is_Imported', 1)
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
            ->setTableId('transaction-table')
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
            ])->fixedColumns([
                'fixedColumns' => [
                'leftColumns' => 1, // Fix the first column (Ledger Ref)
            ],
            'fixedHeader' => false, 
            ]);
            
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('Transaction_Date')->title('Transaction Date')->sortable(false),
            Column::make('file.Ledger_Ref')->title('Ledger Ref')->sortable(false),
            Column::make('Bank_Account_Name')->title('Bank Account (Type)')->sortable(false),
            Column::make('Paid_In_Out')->title('Paid In/Out')->sortable(false),
            Column::make('Reference')->title('Reference')->sortable(false),
            Column::make('Payment_Type_Name')->title('Payment Type')->sortable(false),
            Column::computed('Net_Amount')->title('Net Amount')->sortable(false),
            Column::computed('Vat_Amount')->title('VAT Amount')->sortable(false),
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
        return 'Transaction_' . date('YmdHis');
    }
}
