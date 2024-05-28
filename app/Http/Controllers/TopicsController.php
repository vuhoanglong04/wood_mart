<?php

namespace App\Http\Controllers;

use App\Models\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('topics.view')) {
            abort(404);
        }
        $topics = Topics::withTrashed()->get();
        return view('topics.list', compact('topics'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('topics.add')) {
            abort(404);
        }
        $request->validate([
            'topic_name'=>'required | unique:topics,topic_name',

        ],[
            'topic_name.required'=>'Please enter topic name',
            'topic_name.unique'=>'Topic name has already taken'
        ]);
        $topic = new Topics();
        $topic->topic_name = $request->topic_name;
        $topic->parent_topic_id = $request->parent_topic_id;
        $topic->save();
        return back()->with('success' , 'Add topic successfully');
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
        if (!Gate::allows('topics.edit')) {
            abort(404);
        }
        $topic = Topics::find($id);
        $topics = Topics::where('id', '!=',$id)->get();
        return view('topics.edit' , compact('topic' , 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Gate::allows('topics.edit')) {
            abort(404);
        }
        $request->validate([
            'topic_name'=>'required',

        ],[
            'topic_name.required'=>'Please enter topic name',
        ]);
        $topic = Topics::find($id);
        $topic->topic_name = $request->topic_name;
        $topic->parent_topic_id = $request->parent_topic_id;
        $topic->save();
        return redirect()->route('admin.topics.index')->with('success' ,'Update topic successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('topics.forceDelete')) {
            abort(404);
        }
        $topic = Topics::find($id);
        if($topic)$topic->forceDelete();
        return true;
    }

    public function softDelete($id){
        if (!Gate::allows('topics.delete')) {
            abort(404);
        }
        $topic = Topics::find($id);
        if($topic)$topic->delete();
        return true;
    }
    public function restore($id){
        if (!Gate::allows('topics.restore')) {
            abort(404);
        }
        $topic = Topics::withTrashed()->find($id);
        if($topic)$topic->restore();
        return true;
    }
}
