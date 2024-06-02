<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('posts.view')) {
            abort(404);
        }
        $posts = Posts::withTrashed()->get();
        return view('posts.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('posts.add')) {
            abort(404);
        }
        $topics = Topics::withTrashed()->get();
        return view('posts.add', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->post_theme);
        if (!Gate::allows('posts.add')) {
            abort(404);
        }
        $request->validate([
            'topic_id' => 'required',
            'slug' => 'required',
            'title' => 'required | min:10',
            'content' => 'required',
            'theme' => ["required", 'mimes:jpeg,png', 'max:5120'],
        ], [
            'topic_id.required' => "Please choose a topic",
            'title.required' => "Please enter a slug",
            'slug.required' => "Please choose a topic",
            'content.required' => "Please enter content",
            'theme.required' => "Please upload post theme",
            'theme.mimes' => 'The :attribute must be a file of type: :values.',
            'theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ]);
        $post = new Posts();
        $post->user_id = Auth::user()->id;
        $post->topic_id = $request->topic_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        $cloudinaryImage = new Cloudinary();
        $cloudinaryImage = $request->theme->storeOnCloudinary('posts');
        $url = $cloudinaryImage->getSecurePath();
        $public_id = $cloudinaryImage->getPublicId();
        $post->theme = $url;
        $post->id_theme = $public_id;
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', "Add post successfully");
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
        if (!Gate::allows('posts.edit')) {
            abort(404);
        }
        $topics = Topics::withTrashed()->get();

        $post = Posts::withTrashed()->find($id);
        return view('posts.edit', compact('post', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Gate::allows('posts.edit')) {
            abort(404);
        }
        $request->validate([
            'topic_id' => 'required',
            'title' => 'required | min:10',
            'slug'=>'required',
            'content' => 'required',
            'theme' => ["nullable", 'mimes:jpeg,png', 'max:5120'],
        ], [
            'topic_id.required' => "Please choose a topic",
            'title.required' => "Please enter a title",
            'slug.required' => "Please enter a slug",
            'content.required' => "Please enter content",
            'theme.mimes' => 'The :attribute must be a file of type: :values.',
            'theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ]);
        $post = Posts::withTrashed()->find($id);
        $post->topic_id = $request->topic_id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        if ($request->theme) {
        Cloudinary::destroy($post->id_theme);
            $cloudinaryImage = new Cloudinary();
            $cloudinaryImage = $request->theme->storeOnCloudinary('posts');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $post->theme = $url;
            $post->id_theme = $public_id;
        }
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', "Update post successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('posts.forceDelete')) {
            abort(404);
        }
        $post = Posts::withTrashed()->find($id);
        if ($post) {
         Cloudinary::destroy($post->id_theme);
            $post->forceDelete();
            return true;
        }
    }
    public function softDelete($id)
    {
        if (!Gate::allows('posts.delete')) {
            abort(404);
        }
        $post = Posts::find($id);
        if ($post)
            $post->delete();
        return true;
    }
    public function restore($id)
    {
        if (!Gate::allows('posts.restore')) {
            abort(404);
        }
        $post = Posts::withTrashed()->find($id);
        if ($post)
            $post->restore();
        return true;
    }
}
