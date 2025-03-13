<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'user',
        ]);

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function login(array $data)
    {
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return null;
        }

        $user = Auth::user();
        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    // Hàm xử lý đăng xuất người dùng
    public function logout($user)
    {
        $user->tokens()->delete();
        return true;
    }
}
