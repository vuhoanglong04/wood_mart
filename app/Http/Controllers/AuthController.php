<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function login(AuthRequest $request){
        $email = $request->email;
        $password = $request->password;

            if (Auth::attempt(['email'=>$email,'password'=> $password])) {
                $request->session()->regenerate();
                $request->session()->flash('success', 'Đăng nhập thành công!');
                $user = User::find(Auth::user()->id);
                $user->is_online = 1;
                $user->save();
                return redirect()->intended('admin')->with('welcome', 'Welcome'.Auth::user()->name);
            }else return back()->with('msg' , 'Email or password incorrect')->withInput($request->all());;

    }

    public function logout(Request $request){

        $user = User::find(Auth::user()->id);
        $user->is_online = 0;
        $user->save();
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
