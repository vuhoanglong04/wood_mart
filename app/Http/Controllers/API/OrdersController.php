<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrdersResource;
use App\Models\OrderDetail;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return  Orders::with('user')->with('shipping')->with('userPayment.payment')->get();

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
        $newOrder = new Orders();
        $newOrder->address = $request->address;
        $newOrder->user_id = $request->user_id;
        $newOrder->shipping_id = $request->shipping_id;
        $newOrder->user_payment_id = $request->user_payment_id;
        $newOrder->total = $request->total;
        $newOrder->status= $request->status;
        $newOrder->save();
        foreach ($request->products as $product){
            $detail = new OrderDetail();
            $detail->order_id = $newOrder->id;
            $detail->product_id = $product['product_id'];
            $detail->color_id = $product['color_id'];
            $detail->material_id = $product['material_id'];
            $detail->product_variant_img = $product['product_variant_img'];
            $detail->price = $product['price'];
            $detail->quantity = $product['quantity'];
            $detail->save();
        }
        $arr = [
            'status' => 201,
            'message' => "Create order sucessfully",
            'data' => $newOrder
        ];
        return response()->json($arr, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Orders::with('user')->with('shipping')->with('userPayment')->where('id', $id)->first();
        if($order){
            $orderDetail = OrderDetail::where('order_id', $order->id)->get();
            $arr = [
                'status' => 201,
                'order' => $order,
                'order-detail'=> $orderDetail
            ];
            return response()->json($arr, 201);

        }else{
            $arr = [
                'status' => 404,
                'message' => "Order not found",
            ];
            return response()->json($arr, 404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order =  Orders::find($id);
        if($order){
            $order->status = $request->status ;
            $order->save();
            $arr = [
                'status' => 200,
                'message' => "Update sucessfully",
                'data' =>$order
            ];
            return response()->json($arr, 200);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Order not found",
            ];
            return response()->json($arr, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
