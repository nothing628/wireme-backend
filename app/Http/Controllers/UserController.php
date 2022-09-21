<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    public function getUserProfile(Request $request)
    {
        $currentUser = $request->user();

        return response()->json([
            'user' => $currentUser
        ]);
    }

    public function updateUserProfile()
    {
        return response()->json([]);
    }

    public function createUserToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $ex = ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);

            throw $ex;
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function revokeUserToken(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['success' => true]);
    }

    public function registerUser(RegisterUserRequest $request)
    {
        $data = $request->only(['name', 'username', 'email', 'password']);

        return response()->json([
            'user' => $data
        ], 201);
    }
}
