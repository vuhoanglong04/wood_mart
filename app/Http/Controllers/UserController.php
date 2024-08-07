<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Cart;
use App\Models\User;
use App\Models\Groups;
use App\Models\Orders;
use Nette\Utils\Image;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Exports\CustomersExport;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



use Maatwebsite\Excel\Facades\Excel;

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
        $newUser->password = $request->password;
        $newUser->phone_number = $request->phone_number;
        $newUser->group_id = $request->group_id;
        if ($request->img) {
            $cloudinaryImage = new Cloudinary();
            $cloudinaryImage = $request->img->storeOnCloudinary('users');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $newUser->img = $url;
            $newUser->id_image = $public_id;
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
        if ($user->deleted_at)
            $user->restore();
        return redirect()->route('admin.users.index')->with('success', "Restore account successfully!");
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
       Cloudinary::destroy($user->id_image);

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
        // dd($request->all());
        if ($request->newPass == 1) {
            $request->validate([
                'email' => "required | email:rfc,dns",
                'password' => "required | min:5",
                'img' => ["nullable", 'mimes:jpeg,png', 'max:5120'],
                'full_name' => "required"

            ], [
                'full_name.required' => "Please enter your full name",
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                "password.required" => "Password must be required",
                "password.min" => "Password must be at least :min characters",
                'img.mimes' => 'The :attribute must be a file of type: :values.',
                'img.max' => 'The :attribute may not be greater than :max kilobytes.'
            ]);
        } else {
            $request->validate([
                'email' => "required | email:rfc,dns",
                'img' => ["nullable", 'mimes:jpeg,png', 'max:5120']
            ], [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                'img.mimes' => 'The :attribute must be a file of type: :values.',
                'img.max' => 'The :attribute may not be greater than :max kilobytes.'
            ]);
        }
        $oldUser = User::withTrashed()->find($id);
        $oldUser->full_name = $request->full_name;
        $oldUser->email = $request->email;
        $oldUser->phone_number = $request->phone_number;
        $oldUser->group_id = $request->group_id;
        if ($request->newPass) {
            $oldUser->password = $request->password;
        }

        if ($request->img) {
            if($oldUser->id_image)Cloudinary::destroy($oldUser->id_image);
            $cloudinaryImage = new Cloudinary();
            $cloudinaryImage = $request->img->storeOnCloudinary('users');
            $url = $cloudinaryImage->getSecurePath();
            $public_id = $cloudinaryImage->getPublicId();
            $oldUser->img = $url;
            $oldUser->id_image = $public_id;
        }

        $oldUser->save();
        return redirect()->route('admin.users.index')->with('success', "Update user successfully!");

    }

    public function detail($id)
    {
        if (!Gate::allows('user.detail')) {
            abort(404);
        }
        $user = User::withTrashed()->find($id);
        $groups = Groups::whereNull('deleted_at')->get();
        $lastestOrders = Orders::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        return view('users.detail', compact('user', 'groups', 'lastestOrders'));
    }
    public function updatePassword($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => "required | min:5 | different:current_password",
            'confirm_password' => "required | min:5 |same:password",

        ], [
            "password.required" => "Password must be required",
            "password.min" => "Password must be at least :min characters",
            "pasword.different" => "New password must be different from old password",
            "confirm_password.required" => "Password must be required",
            "confirm_password.min" => "Password must be at least :min characters",
            "confirm_password.same" => "Confirm password must be as same as password"
        ]);

        if ($validate->fails())
            return $validate->errors();
        $user = User::withTrashed()->find($id);
        if (Hash::check($request->password, $user->password)) {
            return [
                "password" => ["New password must be different from old password"]
            ];
        }
        $user->password = $request->password;
        $user->save();
        return true;
    }

    public function exportExcel()
    {

        $fileExt = 'xlsx';
        $exportFormat = \Maatwebsite\Excel\Excel::XLSX;

        $filename = "users-" . date('d-m-Y') . "." . $fileExt;
        return Excel::download(new UsersExport, $filename, $exportFormat);
    }
}

