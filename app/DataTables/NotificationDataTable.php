<?php

namespace App\DataTables;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
use Auth;

class NotificationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('updated_at', function (Notification $quotation) {
                return $quotation->updated_at->format('d M Y, h:i a');
            })
            ->editColumn('message', function (Notification $quotation) {
                $data = json_decode($quotation->data);
                return $data->message;
            })
            ->editColumn('status', function (Notification $quotation) {
                $data = json_decode($quotation->data);
                return $data->status_code . ' ' . strtoupper($data->status_msg);
            })
            ->editColumn('link', function (Notification $quotation) {
                $data = json_decode($quotation->data);
                if (!empty($data->record_module) && $data->record_module == 'quotation') {
                    $link = '<a class="text-gray-800 text-hover-primary fw-semibold" target="_blank" href="' . route('quotation.list', ['signnow_document_id' => $data->record_ref_number, 'record_id' => $data->record_id]) . '" class="btn btn-link">View</a>';
                } else {
                    $link = '<a class="text-gray-800 text-hover-primary fw-semibold" href="#" class="btn btn-link">View</a>';
                }
                return view('pages/apps.notification._link', compact('link'));
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Notification $model): QueryBuilder
    {
        //delete the older records
        // Assuming you want to keep records from the last week
        $notification_auto_deletion_days = (!empty(env('NOTIFICATION_AUTO_DELETION_DAYS'))) ? env('NOTIFICATION_AUTO_DELETION_DAYS') : 7;
        $oneWeekAgo = now()->subDays($notification_auto_deletion_days);
        DB::table('notifications')->whereNotNull('read_at')->where('read_at', '<', $oneWeekAgo)->delete();
        //list the data
        return $model->newQuery()->where('notifiable_id', '=', Auth::id())->orderBy('updated_at', 'DESC');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('notifications-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('link')->exportable(false)->printable(false)->width(60),
            Column::computed('message')->exportable(false)->printable(false),
            Column::computed('status')->exportable(false)->printable(false)->addClass('text-bold'),
            Column::make('updated_at')
        ];
    }
}
