<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('categories.view')) {
            abort(404);
        }
        // dd(Auth::user()->hasPermission('categories' , 'add'));
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
            'category_name'=>"required",
            'icon'=>"required | max:5120",
            'background'=>"required | mimes:jpeg,png | max:5120",
        ] , [
            'category_name.required'=>"Please enter a category name",
            'icon.required'=>"Please upload icon",
            'icon.max' => 'The :attribute may not be greater than :max kilobytes.',
            'background.required'=>"Please upload background",
            'background.mimes' => 'The :attribute must be a file of type: :values.',
            'background.max' => 'The :attribute may not be greater than :max kilobytes.',
        ]);
        $newCate = new Category();
        $newCate->category_name = $request->category_name;
        $newCate->parent_category_id = $request->parent_category_id;
         $cloudinaryImage = new Cloudinary();
        //Icon
        $cloudinaryImage = $request->icon->storeOnCloudinary('category');
        $url = $cloudinaryImage->getSecurePath();
        $id_icon = $cloudinaryImage->getPublicId();
        $newCate->icon = $url;
        $newCate->id_icon = $id_icon;
        //Background
        $cloudinaryImage = $request->background->storeOnCloudinary('category');
        $url = $cloudinaryImage->getSecurePath();
        $id_background = $cloudinaryImage->getPublicId();
        $newCate->background = $url;
        $newCate->id_background = $id_background;
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
        if (!Gate::allows('categories.edit')) {
            abort(404);
        }
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
            'category_name'=>"required",
            'icon'=>"nullable | max:5120",
            'background'=>"nullable | mimes:jpeg,png | max:5120",
        ] , [
            'category_name.required'=>"Please enter a category name",
            'icon.required'=>"Please upload icon",
            'icon.max' => 'The :attribute may not be greater than :max kilobytes.',
            'background.required'=>"Please upload background",
            'background.mimes' => 'The :attribute must be a file of type: :values.',
            'background.max' => 'The :attribute may not be greater than :max kilobytes.',
        ]);
        if(Category::withTrashed()->where('category_name',$request->category_name)->where('id' , '!=' , $id)->first()){
            return back()->with('unique' , 'Already have category name '.$request->category_name)->withInput();
        }
        $category = Category::withTrashed()->find($id);
        $category->category_name = $request->category_name;
        if($request->parent_category_id)$category->parent_category_id = $request->parent_category_id;
        $cloudinaryImage = new Cloudinary();
        //Icon
        if($request->icon){
             Cloudinary::destroy($category->id_icon);
            $cloudinaryImage = $request->icon->storeOnCloudinary('category');
            $url = $cloudinaryImage->getSecurePath();
            $id_icon = $cloudinaryImage->getPublicId();
            $category->icon = $url;
            $category->id_icon = $id_icon;
        }
        //Background
        if($request->background){
            Cloudinary::destroy($category->id_background);
            $cloudinaryImage = $request->background->storeOnCloudinary('category');
            $url = $cloudinaryImage->getSecurePath();
            $id_background = $cloudinaryImage->getPublicId();
            $category->background = $url;
            $category->id_background = $id_background;
        }

        $category->save();
        return redirect()->route('admin.category.index')->with('success' , 'Edit category sucessfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::withTrashed()->find($id);
        Cloudinary::destroy($category->id_icon);
        Cloudinary::destroy($category->id_background);
        $category->forceDelete();
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
