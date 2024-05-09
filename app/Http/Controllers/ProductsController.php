<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use App\Models\Category;
use App\Models\Products;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use App\DataTables\UsersDataTable;
use App\DataTables\ProductsDataTable;
use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $dataTable)
    {
        return $dataTable->render('products.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        $newPr = new Products();
        $newPr->product_name = $request->product_name;
        $newPr->price = $request->price;
        $newPr->category_id = $request->category_id;
        $newPr->product_description = $request->product_description;
        $newPr->product_theme = $request->product_theme->getClientOriginalName();
        $request->product_theme->storeAs('public/products', $request->product_theme->getClientOriginalName());
        $newPr->save();
        return redirect()->route('admin.products.index')->with('success', 'Add product sucessfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::withTrashed()->find($id);
        $colors = Colors::withTrashed()->get();
        $materials = Materials::withTrashed()->get();
        $listVariant = ProductsVariant::withTrashed()->where('product_id', $id)->get();
        $listColorsOfProduct = ProductsVariant::with('color')->where('product_id', $id)->distinct('color_id')->pluck('color_id');
        $colors = Colors::whereIn('id', $listColorsOfProduct)->get();
        $listMaterial = ProductsVariant::withTrashed()->with('material')->where('product_id', $id)->distinct('material_id')->pluck('material_id');
        $material = Materials::whereIn('id', $listMaterial)->get();
        return view('products.detail', compact('product', 'colors', 'materials', 'listVariant' , 'material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Products::withTrashed()->find($id);
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => "required",
            'price' => "required | integer",
            'category_id' => "required",
            "product_description" => "required",
            'product_theme' => ["nullable", 'mimes:jpeg,png', 'max:5120']
        ], [
            'product_name.required' => "Please enter product name",
            'price.required' => "Please enter price",
            'price.integer' => 'Price must be a number',
            'category_id.required' => "Please choose category",
            "product_description.required" => "Please enter product description",
            'product_theme.mimes' => 'The :attribute must be a file of type: :values.',
            'product_theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ]);
        if (Products::withTrashed()->where('product_name', $request->product_name)->where('id', '!=', $id)->first()) {
            return back()->with('unique', 'Already have product name ' . $request->product_name)->withInput();
        }
        $old = Products::withTrashed()->find($id);
        $old->product_name = $request->product_name;
        $old->price = $request->price;
        $old->category_id = $request->category_id;
        if ($request->product_theme) {
            $old->product_theme = $request->product_theme->getClientOriginalName();
            $request->product_theme->storeAs('public/products', $request->product_theme->getClientOriginalName());
        }
        $old->product_description = $request->product_description;
        $old->save();
        return redirect()->route('admin.products.index')->with('success', 'Edit product sucessfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Products::withTrashed()->find($id)->forceDelete();
        ;
    }

    public function softDelete($id)
    {
        Products::withTrashed()->find($id)->delete();
        return true;
    }
    public function restore($id)
    {
        Products::withTrashed()->find($id)->restore();
        return true;
    }
}
