<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Register new user service
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password'])
            ]);

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ];
        } catch (\Exception $e) {
            \Log::error('Register failed ' . $e->getMessage());
            throw $e;
        }
    }
}
