<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Mail\SignUpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => "required | email:rfc,dns | unique:users,email",
                'password' => "required | min:5",
            ], [
                'full_name.required'=>'Please enter your full name',
                'email.required' => "Please enter your email address",
                'email.email' => "Email is not valid",
                'email.unique' => "Email already exists",
                "password.required" => "Please enter your password",
                "password.min" => "Password must be at least :min characters",
            ]);
            if ($validator->fails()) {
                $arr = [
                    'success' => false,
                    'status' => 500,
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ];
                return response()->json($arr, 500);
            }

            $user = new User();
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            $arr = [
                'status' => 201,
                'message' => "Register sucessfully",
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'data' => $user
            ];
            return response()->json($arr, 201);

        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error!',
                'error' => $error,
            ]);
        }
    }

    public function login(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'email' => "required | email:rfc,dns",
                'password' => "required | min:5",
            ], [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                "password.required" => "Password must be required",
                "password.min" => "Password must be at least :min characters",
            ]);

            if ($validator->fails()) {
                $arr = [
                    'success' => false,
                    'status' => 500,
                    'message' => 'Validation failed',
                    'data' => $validator->errors()
                ];
                return response()->json($arr, 500);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = User::find(Auth::user()->id);
                $user->is_online = 1;
                $user->save();
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'status_code' => 200,
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                ]);
            } else {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Wrong password or email'
                ]);
            }

        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error!',
                'error' => $error,
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout successfully!',
        ]);
    }

    public function loginGoogle()
    {
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_USER')]);
        $redirectResponse = Socialite::driver('google')->stateless()->redirect();
        $redirectUrl = $redirectResponse->getTargetUrl();

        return response()->json(['redirect_url' => $redirectUrl]);
    }
    public function loginGoogleHandle()
    {
        config(['services.google.redirect' => env('GOOGLE_REDIRECT_USER')]);
        $googleAccount = Socialite::driver('google')->stateless()->user();
        $findUser = User::where('email', $googleAccount->email)->first();
        if ($findUser) {
            $findUser->is_online = 1;
            $findUser->save();
            $arr = [
                'status' => 200,
                'message' => "Login sucessfully",
                'data' => $findUser
            ];
            return response()->json($arr, 200);
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
            $arr = [
                'status' => 200,
                'message' => "Login sucessfully",
                'data' => $newUser
            ];
            return response()->json($arr, 200);
        }
    }
}
