<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\Orders;
use App\Models\ShippingMethod;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class OrdersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $orders = Orders::with('user')->with('shipping')->with('userPayment.payment');
        return (new EloquentDataTable($orders))

            ->setRowId('id');

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Orders $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
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
            Column::computed('user_id')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('address'),
            Column::make('shipping_id'),
            Column::make('user_payment_id'),
            Column::make('total'),
            Column::make('status'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
