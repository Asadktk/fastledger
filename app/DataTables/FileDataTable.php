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
        return (new EloquentDataTable($query))
            ->addColumn('action', fn($row) => $this->actionColumn())

            ->setRowId('File_ID'); 
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(File $model): QueryBuilder
    {
        $userClientId = auth()->user()->Client_ID; // Assuming the current user's Client_ID is accessible this way
        // dd($userClientId);
        return $model->newQuery()
            ->where('Client_ID', $userClientId)
        ; // Adjust 'Live' as per your Status column values
    }


    protected function actionColumn(): string
    {
        return '<div class="hstack gap-2 fs-15 text-center">
                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"><i class="ri-download-2-line"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"><i class="ri-edit-line"></i></a>
                </div>';
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('file-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->scrollX(true) // Enable horizontal scrolling
            ->dom('Bfrtip') // Set dom structure to place buttons correctly
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

            Column::make('File_Date')->title('Date'),
            Column::make('Ledger_Ref')->title('Ledger Ref'),
            Column::make('Matter')->title('Matter'),
            Column::make('First_Name')->title('First Name'),
            Column::make('Last_Name')->title('Last Name'),
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

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'File_' . date('YmdHis');
    }
}
