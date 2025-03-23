<?php

namespace App\DataTables;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FileOpeningReport extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        if (request()->filled('from_date') && request()->filled('to_date')) {
            $query->whereBetween('File_Date', [
                request('from_date'),
                request('to_date'),
            ]);
        }

        return (new EloquentDataTable($query))
            ->addIndexColumn() // Adds an auto-incrementing index column
            ->addColumn('Full_Name', fn($row) => $row->First_Name . ' ' . $row->Last_Name)
            ->addColumn('Address', fn($row) => $row->Address1 . ' ' . $row->Address2 . ' ' . $row->Town . ' ' . $row->Post_Code)
            ->editColumn('File_Dates', fn($row) => \Carbon\Carbon::parse($row->File_Date)->format('Y-m-d'))
            ->editColumn('Ledger_Ref', function ($row) {
                return '<a href="' . url('/file/update/' . $row->File_ID) . '" class="text-primary">' . $row->Ledger_Ref . '</a>';
            })
            
            ->editColumn('Status', function ($row) {
                $statusMap = [
                    'L' => ['name' => 'Live'],
                    'C' => ['name' => 'Close'],
                    'A' => ['name' => 'Abortive'],
                    'I' => ['name' => 'Close Abortive'],
                ];
                return $statusMap[$row->Status]['name'] ?? $row->Status;
            })
            ->rawColumns(['Ledger_Ref', 'Status'])
            ->setRowId('File_ID');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(File $model): QueryBuilder
    {
        $userClientId = auth()->user()->Client_ID;

        return $model->newQuery()
            ->select([
                'File_ID',
                'File_Date',
                'Ledger_Ref',
                'Matter',
                'First_Name',
                'Last_Name',
                'Address1',
                'Address2',
                'Town',
                'Post_Code',
                'Fee_Earner',
                'Status',
                'File_Date'
            ])
            ->where('Client_ID', $userClientId);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('file-table')
            ->columns($this->getColumns())
            ->orderBy(1)
            ->selectStyleSingle()
            ->responsive(true)  
            ->pagingType('full_numbers')  
            ->buttons([
                Button::make('excel')->addClass('btn btn-success'),
                Button::make('csv')->addClass('btn btn-primary'),
                Button::make('pdf')->addClass('btn btn-danger'),
                Button::make('print')->addClass('btn btn-secondary'),
                Button::make('reset')->addClass('btn btn-warning'),
                Button::make('reload')->addClass('btn btn-info')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')->title('S/No')->width(50)->addClass('text-center'),
            Column::make('File_Date')->title('File Open Date'),
            Column::make('Ledger_Ref')->title('Ledger Ref')->exportable(true)->printable(true),
            Column::make('Matter')->title('Matter'),
            Column::make('Full_Name')->title('Client Name'),
            Column::make('Address')->title('Property/Matter Address'),
            Column::make('Fee_Earner')->title('Fee Earner'),
            Column::make('Status')->title('Status'),
            Column::make('File_Date')->title('Close Date')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'File_' . date('YmdHis');
    }
}
