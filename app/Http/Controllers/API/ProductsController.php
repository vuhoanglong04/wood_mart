<?php

namespace App\Http\Controllers\API;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductsVariant;
use Illuminate\Support\Facades\DB;
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

    public function index(Request $request)
    {
        $products = Products::with('category')->with('variants');
        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }
        if($request->color_id && !$request->material_id) {
            $color = $request->color_id;
            $products = $products->whereHas('variants', function ($query) use ($color) {
                $query->where('color_id', $color);
            });
        }
        if($request->material_id && !$request->color_id) {
            $material = $request->material_id;
            $products = $products->whereHas('variants', function ($query) use ($material) {
                $query->where('material_id', $material);
            });
        }

        if($request->material_id && $request->color_id) {
            $material = $request->material_id;
            $color = $request->color_id;

            $products = $products->whereHas('variants', function ($query) use ($material , $color) {
                $query->where('material_id', $material)->where("color_id" , $color);
            });
        }
        if($request->from && $request->to){
            $products = $products->whereBetween('price' , [$request->from , $request->to]);
        }
        if($request->sort_low_to_high){
            $products = $products->orderBy('price' , 'asc');
        }
        if($request->sort_high_to_low){
            $products = $products->orderBy('price' , 'desc');
        }

        $products = $products->paginate(10);

        if($request->group_by_category){
            $products = Products::with('category')->select('category_id' , DB::raw('COUNT(id)'))->groupBy('category_id')->get();
        }
        return $products;
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
        $product = Products::find($id)->with('category')->first();
        if ($product) {
            $arr = [
                'status' => 200,
                'message' => "success",
                'data' => [
                    'product' => $product,
                    'variant' => ProductsVariant::where('product_id', $id)->with('color')->with('material')->get()
                ]
            ];
            return response()->json($arr, 200);
        } else {
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
        if ($product) {
            $product->delete();
            $arr = [
                'status' => 200,
                'message' => "Delete product sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "Product Not Found"
            ];
            return response()->json($arr, 404);
        }

    }
    public function restore($id)
    {
        $product = Products::withTrashed()->find($id);
        if ($product->deleted_at) {
            $product->restore();
            $arr = [
                'status' => 200,
                'message' => "Restore product sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "Product Not Found"
            ];
            return response()->json($arr, 404);
        }
    }
    public function forceDelete($id)
    {
        $product = Products::withTrashed()->find($id);
        if ($product) {
            $product->forceDelete();
            $arr = [
                'status' => 200,
                'message' => "Delete product sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "Product not found"
            ];
            return response()->json($arr, 404);
        }
    }
}
