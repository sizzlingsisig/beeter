<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
  public function register(Request $request)
{
    $fields = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'password' => bcrypt($fields['password']),
    ]);

    $token = $user->createToken('apptoken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ], 201);
}


    /**
     * Login an existing user.
     */
 public function login(Request $request)
{
    $fields = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $fields['email'])->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($fields['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('apptoken')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}

    /**
     * Logout and revoke the current token.
     */
public function logout(Request $request)
{
    if (!$request->user()) {
        return response()->json(['error' => 'No user authenticated'], 401);
    }

    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out']);
}

}
