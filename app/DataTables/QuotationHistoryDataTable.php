<?php

namespace App\DataTables;

use App\Http\Controllers\JLSignnowHelpersController;
use App\Models\Quotation;
use App\Models\QuotationHistory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class QuotationHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Quotation $quotation) {
                return $quotation->created_at->format('d M Y, h:i a');
            })
            ->editColumn('updated_at', function (Quotation $quotation) {
                return $quotation->updated_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (Quotation $quotation) {
                $signnow_helper_obj = new JLSignnowHelpersController();
                return view('pages/apps.quotation-history.columns._actions', compact('quotation','signnow_helper_obj'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Quotation $model): QueryBuilder
    {
        $query = $model->newQuery();
        $query->where('parent_quotation', '=', $this->parent_id);
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('quotations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/quotation/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('prepared_date'),
            Column::make('assembly_type'),
            Column::make('manufacturer'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make('status'),
            Column::make('status_update_at'),
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
        return 'Quotations_' . date('YmdHis');
    }
}
