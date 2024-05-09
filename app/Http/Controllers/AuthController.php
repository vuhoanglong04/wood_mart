<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(AuthRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
       if(User::where('email', $email)->first()==null){
            return back()->with('notexist', 'Account not exist!')->withInput($request->all());
       }
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            $user = User::find(Auth::user()->id);
            $user->is_online = 1;
            $user->save();
            return redirect()->intended('admin');
        } else return back()->withErrors(['msg' => 'Wrong email or password'])->withInput($request->all());
        ;

    }

    public function logout(Request $request)
    {

        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $user->is_online = 0;
            $user->save();
        }
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');


    }
}
