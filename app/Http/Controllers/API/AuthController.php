<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => "required | email:rfc,dns | unique:users,email",
                'password' => "required | min:5",
            ], [
                'email.required' => "Email must be required",
                'email.email' => "Email is not valid",
                'email.unique' => "Email already exists",
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

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout successfully!',
        ]);
    }
}
