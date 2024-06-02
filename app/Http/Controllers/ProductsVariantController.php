<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use App\Http\Requests\VariantRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductsVariantController extends Controller
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
    public function store(VariantRequest $request)
    {
        if (ProductsVariant::withTrashed()->where('product_id', $request->id)->where('color_id', $request->color_id[0])->where('material_id', $request->material_id)->first()) {
            return back()->with('unique', 'Already have variant with this color and material')->withInput();
        }
        $newItem = new ProductsVariant();
        $newItem->product_id = $request->id;
        $newItem->color_id = $request->color_id[0];
        $newItem->material_id = $request->material_id;
        $newItem->price = $request->price;
        $newItem->qty_in_stock = $request->qty_in_stock;

        $cloudinaryImage = new Cloudinary();
        $cloudinaryImage = $request->img->storeOnCloudinary('variants');
        $url = $cloudinaryImage->getSecurePath();
        $public_id = $cloudinaryImage->getPublicId();

        $newItem->img = $url;
        $newItem->id_image = $public_id;
        $newItem->save();
        return back()->with('success', 'Add Variant Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ProductsVariant::withTrashed()->where('product_id', $id)->with('color')->with('material')->get();
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
       $variant =  ProductsVariant::withTrashed()->find($id);
       Cloudinary::destroy($variant->id_image);
       $variant->forceDelete();
        return true;
    }
    public function softDelete($id){
        ProductsVariant::withTrashed()->find($id)->delete();
        return true;
    }
    public function restore($id){
        ProductsVariant::withTrashed()->find($id)->restore();
        return true;
    }
}
