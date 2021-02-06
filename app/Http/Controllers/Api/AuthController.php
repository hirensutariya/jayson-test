<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|max:55',
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success'=>false
            ],400);
        } else {

            $validatedData['username'] = $request->username;
            $validatedData['first_name'] = $request->first_name;
            $validatedData['last_name'] = $request->last_name;
            $validatedData['email'] = $request->email;
            $validatedData['password'] = Hash::make($request->password);

            $user = User::create($validatedData);

            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken
            ],201);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success'=>false
            ],400);
        } else {

            $loginData['email'] = $request->email;
            $loginData['password'] = $request->password;

            if (!Auth::attempt($loginData)) {
                return response(['message' => 'This User does not exist, check your details'], 400);
            }

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return response()->json([
                'user' => Auth::user(),
                'access_token' => $accessToken
            ],201);
        }
    }
}
