<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if (!Gate::allows('orders.detail')) {
            abort(404);
        }
        $order = Orders::find($id);
        $listProductInOrder = OrderDetail::where('order_id', $id)->get();
        $total = 0;
        foreach ($listProductInOrder as $key=>$value){
            $total +=$value->quantity * $value->price;
        }
        // dd($listProductInOrder);
        return view('orders.detail' , compact('order' , 'listProductInOrder' , 'total'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
