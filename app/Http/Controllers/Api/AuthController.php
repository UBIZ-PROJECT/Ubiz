<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use App\User;
use JWTAuthException;

class AuthController extends Controller
{
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
        AuthenticatesUsers::guard insteadof RegistersUsers;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        $success = true;
        $message = [];

        $rules = [
            'email' => 'required'
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            $success = false;
            $message[] = __('Email is required.');
        }

        if($validator->fails() == false) {
            $rules = [
                'email' => 'email'
            ];
            $validator = Validator::make($credentials, $rules);
            if ($validator->fails()) {
                $success = false;
                $message[] = __('Email is wrong format.');
            }
        }

        $rules = [
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            $success = false;
            $message[] = __('Password is required.');
        }

        if($success == false){
            return response()->json(['success' => false, 'message' => implode("\n", $message)]);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'message' => __('We can not find an account with this credentials.')], 200);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'message' => __('Failed to login, please try again.')], 500);
        }
        // all good so return the token
        return response()->json(['success' => true])->cookie('Authorization', $token);
    }

    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password');
        $rules = [
            'name' => 'required|max:255|',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()]);
        }
        $name = $request->name;
        $email = $request->email;
        $password = bcrypt($request->password);
        User::create(['name' => $name, 'email' => $email, 'password' => $password]);
        return response()->json(['success' => true, 'email' => $email, 'password' => $password]);
    }

    public function logout(Request $request)
    {
        return response()->json(['success' => true, 'message' => "You have successfully logged out."])->cookie('Authorization', '');
    }
}
