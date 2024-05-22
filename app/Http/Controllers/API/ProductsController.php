<?php

namespace App\Http\Controllers\API;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $products = Products::with('category')->get();
        return ProductResource::collection($products);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_name' => "required | unique:products,product_name",
            'price' => "required | integer",
            'category_id' => "required",
            "product_description" => "required",
            'product_theme' => ['nullable', 'mimes:jpeg,png', 'max:5120']
        ], [
            'product_name.required' => "Please enter product name",
            'product_name.unique' => "Product name already exists",
            'price.required' => "Please enter price",
            'price.integer' => 'Price must be a number',
            'category_id.required' => "Please choose category",
            "product_description.required" => "Please enter product description",
            'product_theme.required' => "Please upload product theme",
            'product_theme.mimes' => 'The :attribute must be a file of type: :values.',
            'product_theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }
        $item = new Products();
        $item->product_name = $request->product_name;
        $item->price = $request->price;
        $item->category_id = $request->category_id;
        $item->product_description = $request->product_description;
        $item->product_theme = $request->product_theme->getClientOriginalName();
        $request->product_theme->storeAs('public/products', $request->product_theme->getClientOriginalName());
        $item->save();
        $arr = [
            'status' => 201,
            'message' => "Create product sucessfully",
            'data' => $item
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::find($id);
        if($product){

            return ProductResource::make($product);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Product not found",
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_name' => "required | unique:products,product_name",
            'price' => "required | integer",
            'category_id' => "required",
            "product_description" => "required",
            'product_theme' => ['nullable', 'mimes:jpeg,png', 'max:5120']
        ], [
            'product_name.required' => "Please enter product name",
            'product_name.unique' => "Product name already exists",
            'price.required' => "Please enter price",
            'price.integer' => 'Price must be a number',
            'category_id.required' => "Please choose category",
            "product_description.required" => "Please enter product description",
            'product_theme.required' => "Please upload product theme",
            'product_theme.mimes' => 'The :attribute must be a file of type: :values.',
            'product_theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'status' => 422,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }
        $product = Products::withTrashed()->find($id)->update($request->all());
        $arr = [
            'status' => 200,
            'message' => "Update product sucessfully",
            'data' => Products::find($id)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        if($product){
            $product->delete();
            $arr = [
                'status' => 200,
                'message' => "Delete product sucessfully"
            ];
            return response()->json($arr, 200);
        }else {
            $arr = [
                'status' => 404,
                'message' => "Product Not Found"
            ];
            return response()->json($arr, 404);
        }

    }
    public function restore($id){
        $product = Products::withTrashed()->find($id);
        if($product->deleted_at){
            $product->restore();
            $arr = [
                'status' => 200,
                'message' => "Restore product sucessfully"
            ];
            return response()->json($arr, 200);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Product Not Found"
            ];
            return response()->json($arr, 404);
        }
    }
    public function forceDelete($id){
            $product = Products::withTrashed()->find($id);
        if($product){
            $product->forceDelete();
            $arr = [
                'status' => 200,
                'message' => "Delete product sucessfully"
            ];
            return response()->json($arr, 200);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Product not found"
            ];
            return response()->json($arr, 404);
        }
    }
}
