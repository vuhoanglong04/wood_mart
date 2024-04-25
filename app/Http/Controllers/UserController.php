<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable){
        return $dataTable->render('users.list');
    }
    public function getList(){
        $users = User::query();
        return DataTables::of($users)
        ->make(true);
    }

    public function add(){
        return view('users.add');
    }
}
