<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use App\Models\Category;
use App\Models\Products;
use App\Models\Materials;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Models\ProductsVariant;
use App\DataTables\UsersDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\ProductsDataTable;
use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\Session;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $dataTable)
    {
        if (!Gate::allows('products.view')) {
            abort(404);
        }
        return $dataTable->render('products.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (!Gate::allows('products.add')) {
            abort(404);
        }
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

        $cloudinaryImage = new Cloudinary();
        $cloudinaryImage = $request->product_theme->storeOnCloudinary('products');
        $url = $cloudinaryImage->getSecurePath();
        $public_id = $cloudinaryImage->getPublicId();

        $newPr->product_theme = $url;
        $newPr->id_image = $public_id;

        $newPr->save();
        return redirect()->route('admin.products.index')->with('success', 'Add product sucessfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Gate::allows('products.detail')) {
            abort(404);
        }
        $product = Products::withTrashed()->find($id);
        $colors = Colors::withTrashed()->get();
        $materials = Materials::withTrashed()->get();
        $listVariant = ProductsVariant::withTrashed()->where('product_id', $id)->get();
        $listColorsOfProduct = ProductsVariant::with('color')->where('product_id', $id)->distinct('color_id')->pluck('color_id');
        // $colors = Colors::whereIn('id', $listColorsOfProduct)->get();
        $listMaterial = ProductsVariant::withTrashed()->with('material')->where('product_id', $id)->distinct('material_id')->pluck('material_id');
        $material = Materials::whereIn('id', $listMaterial)->get();
        return view('products.detail', compact('product', 'colors', 'materials', 'listVariant' , 'material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Gate::allows('products.edit')) {
            abort(404);
        }
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
            $cloudinaryImage = new Cloudinary();
            $cloudinaryImage = $request->product_theme->storeOnCloudinary('products');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();

            $old->product_theme = $url;
            $old->id_image = $public_id;

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
        $product =  Products::withTrashed()->find($id);
        Cloudinary::destroy($product->id_image);
        return $product->forceDelete();

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
    public function exportExcel(){
        $fileExt = 'xlsx';
        $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        $filename = "products-".date('d-m-Y').".".$fileExt;
        return Excel::download(new ProductsExport, $filename, $exportFormat);
    }
}
