<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authcontroller extends Controller
{
    public function login(Request $request)
    {
        Log::info('Login request received', ['email' => $request->email]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        Log::info('Validation passed', ['email' => $request->email]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            Log::info('Invalid login details', ['email' => $request->email]);

            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        Log::info('Login successful', ['email' => $request->email]);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info('Token created', ['email' => $request->email, 'token' => $token]);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

}