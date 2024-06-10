<?php

namespace App\Http\Controllers\API;

use Pusher\Pusher;
use App\Models\Orders;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersResource;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Orders::with('user')->with('shipping')->with('userPayment.payment');
        if ($request->user_id) {
            $order = $orders->where('user_id', $request->user_id);
        }
        $orders = $orders->get();
        return $orders;
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
        $newOrder->telephone = $request->telephone;
        $newOrder->user_id = $request->user_id;
        $newOrder->shipping_id = $request->shipping_id;
        $newOrder->payment_id = $request->payment_id;
        $newOrder->voucher = $request->voucher;
        $newOrder->total = $request->total;
        $newOrder->status = $request->status;
        $newOrder->save();
        foreach ($request->products as $product) {
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
         $pusher = new Pusher(
           env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            ['cluster' => env('PUSHER_APP_CLUSTER')]
        );
        $pusher->trigger('woodmart', 'my-event', 'New order have been created');

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
        $order = Orders::with('user')->with('shipping')->with('payment')->where('id', $id)->first();
        if ($order) {
            $orderDetail = OrderDetail::where('order_id', $order->id)->get();
            $arr = [
                'status' => 201,
                'order' => $order,
                'order-detail' => $orderDetail
            ];
            return response()->json($arr, 201);

        } else {
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
        $order = Orders::find($id);
        if ($order) {
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
            $arr = [
                'status' => 200,
                'message' => "Update sucessfully",
                'data' => $order
            ];
            return response()->json($arr, 200);
        } else {
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
