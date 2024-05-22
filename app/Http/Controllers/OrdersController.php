<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use App\DataTables\OrdersDataTable;
use Illuminate\Support\Facades\Gate;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrdersDataTable $dataTable)
    {
        if (!Gate::allows('orders.view')) {
            abort(404);
        }
        return $dataTable->render('orders.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Orders::find($id);
        if ($request->status == 2)
            $order->status = 3;
        else
            $order->status = $request->status;

        if ($request->status == 5) {
            $listItem = OrderDetail::where('order_id', $id)->get();
            foreach ($listItem as $item) {
                $variant = ProductsVariant::where('color_id', $item->color_id)->where('material_id', $item->material_id)->first();
                $variant->qty_in_stock -= $item->quantity;
                if ($variant->qty_in_stock < 0)
                    $variant->qty_in_stock = 0;
                $variant->save();
            }
        }
        $order->save();
        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
