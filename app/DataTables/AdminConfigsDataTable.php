<?php

namespace App\DataTables;

use App\Models\AdminConfig;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use PSpell\Config;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminConfigsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (AdminConfig $adminConfig) {
                return $adminConfig->created_at->format('d M Y, h:i a');
            })
            ->editColumn('updated_at', function (AdminConfig $adminConfig) {
                return $adminConfig->updated_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (AdminConfig $adminConfig) {
                return view('pages/apps.admin.configs.columns._actions', compact('adminConfig'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AdminConfig $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('adminconfigs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/admin/configs/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('key')->addClass('d-flex align-items-center')->name('key'),
            Column::make('value')->searchable(false),
            Column::make('for_ai_prompt')->searchable(false),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AdminConfigs_' . date('YmdHis');
    }
}