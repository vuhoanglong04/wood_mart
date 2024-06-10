<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allCart = Cart::with('user')->with('variant.product');
        if($request->user_id){
            $allCart  = $allCart->where('user_id', $request->user_id);
        }
        $allCart = $allCart->get();
        return $allCart;
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
        $findItemCart  = Cart::where('user_id', $request->user_id)->where('product_variant_id', $request->product_variant_id)->first();
        if($findItemCart){
            $findItemCart->quantity +=$request->quantity;
            $findItemCart->save();
            $arr = [
                'status' => 200,
                'message' => "Increase quantity product in cart successfully",
                'data' => $findItemCart
            ];
            return response()->json($arr, 200);
        }
        else{
            $newItemCart = new Cart();
            $newItemCart->user_id = $request->user_id;
            $newItemCart->product_variant_id = $request->product_variant_id;
            $newItemCart->quantity = $request->quantity;
            $newItemCart->save();
            $arr = [
                'status' => 201,
                'message' => "Add to cart  sucessfully",
                'data' => $newItemCart
            ];
            return response()->json($arr, 201);
        }

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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Cart::find($id);
        $item->quantity=$request->quantity;
        $item->save();
        $arr = [
            'status' => 200,
            'message' => "Update  sucessfully",
            'data' => $item
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Cart::find($id);
        $item->delete();
        $arr = [
            'status' => 200,
            'message' => "Delete  sucessfully",
        ];
        return response()->json($arr, 200);
    }
}
