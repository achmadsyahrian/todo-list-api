<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
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
            return errorResponse('The account does not exist.', 401);
        }

        // Generate a token
        $token = $user->createToken('ToDoList')->plainTextToken;

        return successResponse([
            'user' => $user,
            'token' => $token
        ], 'Login successfully.', 200);
    }

    public function logout(Request $request)
    {
        // Menghapus token yang sedang digunakan pengguna
        $request->user()->currentAccessToken()->delete();

        return successResponse([], 'Logout successfully.');
    }

    public function register(RegisterUserRequest $request)
    {

        $validated = $request->validated();
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Generate a token
        $token = $user->createToken('ToDoList')->plainTextToken;

        return successResponse([
            'user' => $user,
            'token' => $token
        ], 'User registered successfully.', 201);
    }

}
