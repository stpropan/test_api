<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register
    public function register(Request $request) {
        // register validation
        $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:App\Models\User,email|max:255',
                'password' => 'required|string|min:8|max:255|regex:/^(?=.*[0-9])(?=.*[A-Za-z])[0-9A-Za-z]*$/',
            ],
            // custom messages for errors
            [
                'email.unique' => 'This email is already registered',
                'password.regex' => 'Password must contain at least number and character',
            ]
        );

        // retrive all errors
        if ($validator->fails()) {
            return $validator->errors()->toJson();
        }

        // retrive all validated attributes to new user (password autohashing by default User model)
        $user = new User($validator->safe()->all());

        if (!$user->save()) {
            return response()->json(['message' => 'saving user went wrong. Contact with support', 500]);
        }

        return $this->response_json($user->toArray(), 'User successfully created');
    }

    // Login
    public function login(Request $request) {
        
        // login validation
        $validator = Validator::make($request->all(), [
                'email' => 'required|string|exists:App\Models\User,email',
                'password' => 'required|string',
            ],
            [
                'email.exists' => 'This email is not registered yet'
            ]
        );

        // retrive all errors
        if ($validator->fails()) {
            return $validator->errors()->toJson();
        }

        $user = User::query()->where('email', $validator->safe()->email)->first();

        if (Hash::check($validator->safe()->password, $user->password)) {
            return $this->response_json(['api_token' => $user->createToken('user')], 'You have logged in');
        }
        return response()->json(['message' => 'Password is not correct'], 403);
    }
}
