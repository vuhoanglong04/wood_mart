<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Groups;
use Nette\Utils\Image;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        if (!Gate::allows('user.view')) {
            abort(404);
        }
        // dd(Auth::user()->hasPermission('users' , 'forceDelete'));
        return $dataTable->render('users.list');
    }
    public function getList()
    {

        $users = User::withTrashed()->get();
        return DataTables::of($users)
            ->make(true);
    }

    public function add()
    {
        if (!Gate::allows('user.add')) {
            abort(404);
        }
        $groups = Groups::whereNull('deleted_at')->get();
        return view('users.add', compact('groups'));
    }
    public function postUser(UserRequest $request)
    {
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
        return redirect()->route('admin.users.index')->with('success', "Add new user successfully!");
    }

    public function delete($id)
    {
        $user = User::withTrashed()->find($id);
        $user->status = 0;
        $user->save();
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', "Lock account successfully!");
    }
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if($user->deleted_at) $user->restore();
        return redirect()->route('admin.users.index')->with('success', "Restore account successfully!");
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('admin.users.index')->with('success', "Detete successfully!");
    }
    public function edit($id)
    {
        if (!Gate::allows('user.edit')) {
            abort(404);
        }
        $user = User::withTrashed()->find($id);
        $groups = Groups::whereNull('deleted_at')->get();

        return view('users.edit', compact('user', 'groups'));
    }
    public function update($id, Request $request)
    {
        if ($request->newPass == 1) {
            $request->validate([
                'email' => "required | email:rfc,dns",
                'full_name' => "required",
                'password' => "required | min:5",
                'group_id' => "required",
                'phone_number' => "required",
                'img' => ["nullable", 'mimes:jpeg,png', 'max:5120']
            ], [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                "full_name" => "Password must be required",
                "group_id" => "Please select group of user",
                "password.required" => "Password must be required",
                "password.min" => "Password must be at least :min characters",
                'img.mimes' => 'The :attribute must be a file of type: :values.',
                'img.max' => 'The :attribute may not be greater than :max kilobytes.'
            ]);
        } else {
            $request->validate([
                'email' => "required | email:rfc,dns",
                'full_name' => "required",
                'group_id' => "required",
                'phone_number' => "required",
                'img' => ["nullable", 'mimes:jpeg,png', 'max:5120']
            ], [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                "full_name" => "Password must be required",
                "group_id" => "Please select group of user",
                'img.mimes' => 'The :attribute must be a file of type: :values.',
                'img.max' => 'The :attribute may not be greater than :max kilobytes.'
            ]);
        }

        $oldUser = User::withTrashed()->find($id);
        $oldUser->full_name = $request->full_name;
        $oldUser->email = $request->email;
        $oldUser->phone_number = $request->phone_number;
        $oldUser->group_id = $request->group_id;
        if($request->newPass){
            $oldUser->password = $request->password;
        }

        if ($request->img) {
            $request->img->storeAs('public/user' ,$request->img->getClientOriginalName());
            $oldUser->img = $request->img->getClientOriginalName();
        }
        $oldUser->save();
        return redirect()->route('admin.users.index')->with('success', "Update user successfully!");

    }

    public function detail($id){
        if (!Gate::allows('user.detail')) {
            abort(404);
        }
        $user = User::withTrashed()->find($id);
        $groups = Groups::whereNull('deleted_at')->get();
        return view('users.detail' , compact('user' , 'groups'));
    }
    public function updatePassword($id , Request $request){
        $validate = Validator::make($request->all() ,[
                'password' => "required | min:5 | different:current_password",
                'confirm_password' => "required | min:5 |same:password",

        ],[
            "password.required" => "Password must be required",
            "password.min" => "Password must be at least :min characters",
            "pasword.different"=>"New password must be different from old password",
            "confirm_password.required" => "Password must be required",
            "confirm_password.min" => "Password must be at least :min characters",
            "confirm_password.same"=>"Confirm password must be as same as password"
        ]);

        if($validate->fails()) return $validate->errors();
        $user =  User::withTrashed()->find($id);
        if(Hash::check($request->password , $user->password)){
            return  [
                "password"=>["New password must be different from old password"]
            ];
        }
        $user->password = $request->password;
        $user->save();
        return true;
    }
}

