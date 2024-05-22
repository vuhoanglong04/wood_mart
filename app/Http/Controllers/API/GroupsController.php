<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GroupsResource;
use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Groups::all();
        return GroupsResource::collection($groups);
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
        $validator = Validator::make($input,  [
            'group_name' => "required | unique:groups,group_name",
        ],
        [
            'group_name.required' => "Group name must be required",
            'group_name.unique' => "Group name must be unique"
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
        $newGroup = new Groups();
        $newGroup->group_name = $request->group_name;
        $newGroup->save();
        $arr = [
            'status' => 201,
            'message' => "Create groups sucessfully",
            'data' => $newGroup
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Groups::find($id);
        if($group){
            return GroupsResource::make($group);
        }else{
            $arr = [
                'status' => 404,
                'message' => "Group not found",
            ];
            return response()->json($arr, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $validator = Validator::make($input,  [
            'group_name' => "required | unique:groups,group_name",
        ],
        [
            'group_name.required' => "Group name must be required",
            'group_name.unique' => "Group name must be unique"
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
        $oldGroup = Groups::withTrashed()->find($id)->update($input);
          $arr = [
            'status' => 200,
            'message' => "Update group sucessfully"
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy(string $id)
     {
         $group = Groups::find($id);
         if ($group) {
             $group->delete();
             $arr = [
                 'status' => 200,
                 'message' => "Delete group sucessfully"
             ];
             return response()->json($arr, 200);
         } else {
             $arr = [
                 'status' => 404,
                 'message' => "Group Not Found"
             ];
             return response()->json($arr, 404);
         }

     }

     public function restore($id)
     {
        $group = Groups::withTrashed()->find($id);

         if ($group->deleted_at) {
             $group->restore();
             $arr = [
                 'status' => 200,
                 'message' => "Restore group sucessfully"
             ];
             return response()->json($arr, 200);
         } else {
             $arr = [
                 'status' => 404,
                 'message' => "Group Not Found"
             ];
             return response()->json($arr, 404);
         }
     }
     public function forceDelete($id)
     {
        $group = Groups::withTrashed()->find($id);

         if($group){
             $group->forceDelete();
             $arr = [
                 'status' => 200,
                 'message' => "Delete group sucessfully"
             ];
             return response()->json($arr, 200);

         }else{
             $arr = [
                 'status' => 404,
                 'message' => "Group Not Found"
             ];
             return response()->json($arr, 404);
         }
     }
}
