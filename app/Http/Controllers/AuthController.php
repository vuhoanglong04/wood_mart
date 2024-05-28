<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Mail\HelloMail;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        Session::forget('code');
        Session::forget('time');
        Session::forget('success');

        return view('auth.login');
    }
    public function login(AuthRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (User::where('email', $email)->first() == null) {
            return back()->with('notexist', 'Account not exist!')->withInput($request->all());
        }
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            $user = User::find(Auth::user()->id);
            $user->is_online = 1;
            $user->save();
            return redirect()->intended('admin');
        } else
            return back()->withErrors(['msg' => 'Wrong email or password'])->withInput($request->all());
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

    public function forgotPassword()
    {
        Session::forget('code');
        Session::forget('time');
        Session::forget('success');

        return view('auth.forgotPassword');
    }
    public function sendForgotPassword(Request $request)
    {
        $request->validate(
            ['email' => "required | email:rfc,dns"],
            [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
            ]
        );
        $user = User::where('email', $request->email)->first();
        if($user){
            $email = $request->email;
            $code = rand(1000, 9999);
            Session::put(['code' => $code, 'time' => time() + 5000]);
            Session::put('email',$email);
            Mail::to($email)->send(new HelloMail($code));
            return redirect()->route('code-verification');
        }else return back()->with('error' , 'Email not found');
    }
    public function codeVerification()
    {
        return view('auth.codeVerification');
    }
    public function codeVerificationCheck(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|min:4'
        ], [
            'code.required' => 'The code field is required.',
            'code.numeric' => 'The code field must be a number.',
            'code.min' => 'The code field must be 4 digits.'
        ]);

        if(Session::get('code') == $request->code){
            if(time() <= Session::get('time')){
                Session::put('success' , 'true');
                return redirect()->route('reset-password');
            }else return back()->with('error' , 'The code has expired, please send code again');
        }else return back()->with('error' , 'Wrong code. Please try again');
    }
    public function updatePasswordForm(){
            return view('auth.resetPassword');
    }
    public function updateNewPassword(Request $request){
        $validate = Validator::make( $request->all() ,[
            'password' => 'required|min:5',
            'confirmPassword' => 'required|min:5'
        ], [
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least :min characters.',
            'confirmPassword.required' => 'Please confirm the password.',
            'confirmPassword.min' => 'The confirmation password must be at least :min characters.'
        ]);
        if($validate->fails()) return $validate->errors();

        if($request->password != $request->confirmPassword){
            return ['confirmPassword' =>["Confirm password must be the same with password"]];
        }
        $user = User::where('email', Session::get('email'))->first();
        if($user){
            $user->password = $request->password;
            return true;
        }
    }


}
