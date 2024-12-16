<?php

namespace App\Http\Controllers;

use App\Models\User; // import User model
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        // validation
        $validation = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // attempt login, ini tanda seru
        if (! auth()->attempt($validation)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // return response
        return response()->json([
            'message' => 'Login successful',
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('authToken')->plainTextToken,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        // validation
        $validation = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // create user
        $user = User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => bcrypt($validation['password']),
        ]);

        // return response
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function logout()
    {
        // revoke token
        auth()->user()->currentAccessToken()->delete();

        // return response
        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }
}
