<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Groups::withTrashed()->get();
        return view('groups.list' , compact('groups'));
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
        $request->validate(
            [
                'group_name'=> "required | unique:groups,group_name",
            ],[
                'group_name.required'=>"Group name must be required",
                'group_name.unique'=>"Group name must be unique"
            ]
        );
        $newGroup = new Groups();
        $newGroup->group_name = $request->group_name;
        $newGroup->save();
        return back()->with('success', 'Add new group successfully!');
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
        $group = Groups::withTrashed()->find($id);
        return view('groups.edit' ,compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'group_name'=> "required | unique:groups,group_name",
            ],[
                'group_name.required'=>"Group name must be required"
            ]
        );
        $oldGroup = Groups::withTrashed()->find($id);
        $oldGroup->group_name = $request->group_name;
        $oldGroup->save();
        return redirect()->route('admin.groups.index')->with('success' , 'Edit group sucessfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Groups::withTrashed()->find($id);
        $group->forceDelete();
        return true;
    }
    public function softDelete(string $id){
        $group = Groups::withTrashed()->find($id);
        $group->delete();
        return true;
    }
    public function restore(string $id){
        $group = Groups::withTrashed()->find($id);
        $group->restore();
        return true;
    }
}
