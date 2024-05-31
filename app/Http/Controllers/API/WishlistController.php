<?php

namespace App\Http\Controllers\API;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wishlist = Wishlist::with('product');
        if($request->user_id){
            $wishlist = $wishlist->where('user_id', $request->user_id);
        }
        $wishlist = $wishlist->get();
        return $wishlist;
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
        $newItem = new Wishlist();
        $newItem->user_id  = $request->user_id;
        $newItem->product_id = $request->product_id;
        $newItem->save();
        $arr = [
            'status' => 201,
            'message' => "Add sucessfully",
            'data' => $newItem
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $item = Wishlist::find($id);
        $item->delete();
        $arr = [
            'status' => 200,
            'sucess'=>true,
            'message' => "Delete sucessfully",
        ];
        return response()->json($arr, 200);
    }
}
