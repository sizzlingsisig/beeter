<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $service)
    {
        try {
            $data = $service->register($request->validated());

            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }

    public function login(LoginRequest $request, AuthService $service)
    {
        try {
            $data = $service->login($request->validated());

            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Login failed'], 401);
        }
    }

    public function logout(AuthService $service)
    {
        try {
            $service->logout(Auth::user());

            return response()->json(['message' => 'Logged out']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Logout failed'], 500);
        }
    }
}
