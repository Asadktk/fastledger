<?php

namespace App\DataTables;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FileDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Apply date range filter before passing the query to EloquentDataTable
        if (request()->filled('from_date') && request()->filled('to_date')) {
            $query->whereBetween('File_Date', [
                request('from_date'),
                request('to_date'),
            ]);
        }
    
        return (new EloquentDataTable($query))
            ->addColumn('Full_Name', fn($row) => $row->First_Name . ' ' . $row->Last_Name)
            ->editColumn('File_Date', fn($row) => \Carbon\Carbon::parse($row->File_Date)->format('Y-m-d'))
            ->editColumn('Status', function ($row) {
                $statusMap = [
                    'L' => ['name' => 'Live', 'class' => 'success'],
                    'C' => ['name' => 'Close', 'class' => 'secondary'],
                    'A' => ['name' => 'Abortive', 'class' => 'danger'],
                    'I' => ['name' => 'Close Abortive', 'class' => 'warning'],
                ];
    
                $status = $statusMap[$row->Status] ?? ['name' => $row->Status, 'class' => 'dark'];
    
                return '<span class="badge bg-' . $status['class'] . '">
                            <a href="javascript:void(0);" 
                               data-id="' . $row->File_ID . '" 
                               data-status="' . $row->Status . '" 
                               data-bs-toggle="modal" 
                               data-bs-target="#statusModal" 
                               class="status-modal-trigger">
                                ' . $status['name'] . '
                            </a>
                        </span>';
            })
            ->rawColumns(['Status', 'action'])
            ->addColumn('action', fn($row) => $this->actionColumn($row))
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
                // 'Address1',
                'Post_Code',
                'Fee_Earner',
                'Status'
            ])
            ->where('Client_ID', $userClientId);
    }

    /**
     * Define the action column content.
     */
    protected function actionColumn($row): string
    {

        return '<div class="hstack gap-2 fs-15 text-center">
             <a href="javascript:void(0);" 
                class="btn btn-danger btn-sm btn-light delete-button color-danger" 
                data-id="' . $row->File_ID . '" 
                title="Delete">
                 Delete
                </a>
             
                </div>';
    }
 
    public function html(): HtmlBuilder
{
    return $this->builder()
        ->setTableId('file-table')
        ->columns($this->getColumns())
        ->minifiedAjax(route('files.index'))
        ->orderBy(1)
        ->selectStyleSingle()
        ->responsive(true) // Enable responsiveness
        ->pagingType('full_numbers') // Fix pagination buttons
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
            Column::make('File_Date')->title('Date'),
            Column::make('Ledger_Ref')->title('Ledger Ref'),
            Column::make('Matter')->title('Matter'),
            Column::make('Full_Name')->title('Name'),
            Column::make('Address1')->title('Address'),
            Column::make('Post_Code')->title('Post Code'),
            Column::make('Fee_Earner')->title('Fee Earner'),
            Column::make('Status')->title('Status'),
            Column::computed('action')
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
