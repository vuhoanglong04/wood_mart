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
            $findUser->is_online = 1;
            $findUser->save();
            Auth::login($findUser);
            return redirect()->intended('admin');
        } else {
            $newUser = new User();
            $newUser->email = $googleAccount->email;
            $newUser->full_name = $googleAccount->name;

            //regenerate password
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = '';
            for ($i = 0; $i < 10; $i++) {
                $index = random_int(0, strlen($chars) - 1);
                $password .= $chars[$index];
            }
            $newUser->password = $password;
            $newUser->save();
            Mail::to($googleAccount->email)->send(new SignUpMail($password));
            Auth::login($newUser);
            return redirect()->intended('admin');
        }
    }

}
