<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('group')->get();
        return UserResource::collection($users);
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
            'email' => "required | email:rfc,dns | unique:users,email",
            'password' => "required | min:5",
            'full_name' => "required",
            'group_id' => "required",
            'phone_number' => "required",
            'img' => ["nullable",'mimes:jpeg,png','max:5120']
        ], [
            'email.required' => "Email must be required",
            'email.email' => "Email is not valid",
            'email.unique' => "Email must be unique",
            "password.required" => "Password must be required",
            "password.min" => "Password must be at least :min characters",
            "full_name" => "Password must be required",
            "group_id" => "Please select group of user",
            'img.mimes' => 'The :attribute must be a file of type: :values.',
            'img.max' => 'The :attribute may not be greater than :max kilobytes.'
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
        $newUser = new User();
        $newUser->full_name = $request->full_name;
        $newUser->email = $request->email;
        $newUser->password =$request->password;
        $newUser->phone_number = $request->phone_number;
        $newUser->group_id = $request->group_id;
        if ($request->img) {
            $request->img->storeAs('storage/user' ,$request->img->getClientOriginalName());
            $newUser->img = $request->img->getClientOriginalName();
        }
        $newUser->save();
        $arr = [
            'status' => 201,
            'message' => "Create users sucessfully",
            'data' => $newUser
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if($user){

            return UserResource::make($user);
        }else{
            $arr = [
                'status' => 404,
                'message' => "User not found",
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
        $validator = Validator::make($input, [
            'email' => "required | email:rfc,dns | unique:users,email",
            'password' => "required | min:5",
            'full_name' => "required",
            'group_id' => "required",
            'phone_number' => "required",
            'img' => ["nullable",'mimes:jpeg,png','max:5120']
        ], [
            'email.required' => "Email must be required",
            'email.email' => "Email is not valid",
            'email.unique' => "New email must be unique and different from this previous email",
            "password.required" => "Password must be required",
            "password.min" => "Password must be at least :min characters",
            "full_name" => "Password must be required",
            "group_id" => "Please select group of user",
            'img.mimes' => 'The :attribute must be a file of type: :values.',
            'img.max' => 'The :attribute may not be greater than :max kilobytes.'
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
        $user = User::find($id)->update($input);
        $arr = [
            'status' => 201,
            'message' => "Update users sucessfully",
        ];
        return response()->json($arr, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->delete();
            $arr = [
                'status' => 200,
                'message' => "Delete user sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "User Not Found"
            ];
            return response()->json($arr, 404);
        }
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);


        if ($user->deleted_at) {
            $user->restore();
            $arr = [
                'status' => 200,
                'message' => "Restore user sucessfully"
            ];
            return response()->json($arr, 200);
        } else {
            $arr = [
                'status' => 404,
                'message' => "User Not Found"
            ];
            return response()->json($arr, 404);
        }
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if($user){
            $user->forceDelete();
            $arr = [
                'status' => 200,
                'message' => "Delete user sucessfully"
            ];
            return response()->json($arr, 200);
        }else{
            $arr = [
                'status' => 404,
                'message' => "User Not Found"
            ];
            return response()->json($arr, 404);
        }

    }
}
