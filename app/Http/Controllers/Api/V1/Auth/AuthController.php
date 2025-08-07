<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RefreshTokenAction;
use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request, RegisterUserAction $registerUser)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        $result = $registerUser->handle($request->only('name', 'email', 'password'));

        if(!$result) {
            return response()->json(['error'=>'Something went wrong'], 500);

        }
        return response()->json([
            'message' => 'User registered successfully.',
        ], 201);

    }

    public function login(Request $request, LoginUserAction $loginUser)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $result = $loginUser->handle($request->only('email', 'password'));

        if (!$result) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        return response()->json([
            'message' => 'Login successful.',
            'user'    => $result['access_token'],
            'token'   => $result['refresh_token'],
        ], 200);
    }


    public function refresh(Request $request, RefreshTokenAction $action)
    {

        $validate = Validator::make($request->all(), [
            'refresh_token' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        return $action->handle($request);
    }
    public function logout(Request $request, LogoutUserAction $logoutUser)
    {
        $logoutUser->handle($request);

        return response()->json([
            'message' => 'Logged out successfully.'
        ], 200);
    }



}
