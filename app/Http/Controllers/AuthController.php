<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Generate a token
        $token = $user->createToken('ToDoList')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan pengguna
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout..!'
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required|string',
            'email' =>'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate a token
        $token = $user->createToken('ToDoList')->plainTextToken;

        return successResponse([
            'user' => $user,
            'token' => $token
        ], 'User registered successfully.', 201);
    }

}
