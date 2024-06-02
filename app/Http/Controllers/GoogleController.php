<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SignUpMail;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        config(['services.google.redirect' => env('GOOGLE_REDIRECT')]);
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogle(Request $request)
    {
        $googleAccount = Socialite::driver('google')->user();
        $findUser = User::where('email', $googleAccount->email)->first();
        if ($findUser) {
            if ($findUser->group_id != 1) {
                $findUser->is_online = 1;
                $findUser->save();
                Auth::login($findUser);
                return redirect()->intended('admin');
            }else return redirect()->route('login')->with('error' , 'You are not allowed to this page ');
        }
        return redirect()->route('login')->with('error' , 'You are not admin');
    }

}
