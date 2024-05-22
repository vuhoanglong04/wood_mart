<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'category_name' => "required | unique:category,category_name",
            'parent_category_id' => 'required'
        ], [
            'category_name.required' => "Please enter a category name",
            'category_name.unique' => "Category name must be unique",
            'parent_category_id.required' => 'Please choose a parent category'

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
        $newCate = new Category();
        $newCate->category_name = $request->category_name;
        $newCate->parent_category_id = $request->parent_category_id;
        $newCate->save();
        $arr = [
            'status' => 201,
            'message' => "Create category sucessfully",
            'data' => $newCate
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if($category){
            return CategoryResource::make($category);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Category not found",
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
            'category_name' => "required | unique:category,category_name",
            'parent_category_id' => 'required'
        ], [
            'category_name.required' => "Please enter a category name",
            'category_name.unique' => "Category name must be unique",
            'parent_category_id.required' => 'Please choose a parent category'

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
        $category = Category::withTrashed()->find($id)->update($request->all());
        $arr = [
            'status' => 200,
            'message' => "Update category sucessfully",
            'data' => Category::find($id)
        ];
        return response()->json($arr, 200);
    }

    public function destroy(string $id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category) {
            $category->delete();
            $arr = [
                'status' => 200,
                'message' => "Delete category sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "Category Not Found"
            ];
            return response()->json($arr, 404);
        }

    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);

        if ($category->deleted_at) {
            $category->restore();
            $arr = [
                'status' => 200,
                'message' => "Restore category sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "Category Not Found"
            ];
            return response()->json($arr, 404);
        }
    }
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);


        if($category){
            $category->forceDelete();
            $arr = [
                'status' => 200,
                'message' => "Delete category sucessfully"
            ];
            return response()->json($arr, 200);

        }else{
            $arr = [
                'status' => 404,
                'message' => "Category Not Found"
            ];
            return response()->json($arr, 404);
        }
    }
}
