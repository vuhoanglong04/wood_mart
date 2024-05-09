<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withTrashed()->get();
        return view('category.list' , compact('categories'));
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
        $request->validate([
            'category_name'=>"required | unique:category,category_name"
        ] , [
            'category_name.required'=>"Please enter a category name",
            'category_name.unique'=>"Category name must be unique"
        ]);
        $newCate = new Category();
        $newCate->category_name = $request->category_name;
        $newCate->parent_category_id = $request->parent_category_id;
        $newCate->save();
        return back()->with('success', 'Add new category successfully');
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
        $category = Category::withTrashed()->find($id);
        $categories = Category::withTrashed()->get();
        return view('category.edit' , compact('category' ,'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name'=>"required"
        ] , [
            'category_name.required'=>"Please enter a category name"
        ]);
        if(Category::withTrashed()->where('category_name',$request->category_name)->where('id' , '!=' , $id)->first()){
            return back()->with('unique' , 'Already have category name '.$request->category_name)->withInput();
        }
        $category = Category::withTrashed()->find($id);
        $category->category_name = $request->category_name;
        $category->parent_category_id = $request->parent_category_id;
        $category->save();
        return redirect()->route('admin.category.index')->with('success' , 'Edit category sucessfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::withTrashed()->find($id)->forceDelete();
        return true;
    }
    public function softDelete($id){
        Category::withTrashed()->find($id)->delete();
        return true;
    }
    public function restore($id){
        Category::withTrashed()->find($id)->restore();
        return true;
    }
}
