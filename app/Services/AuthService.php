<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user and generate an access token.
     *
     * @param  array  $data
     * @return array{user: \App\Models\User, token: string}
     */
    public function register(array $data): array
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Authenticate a user and generate an access token.
     *
     * @param  array  $credentials
     * @return array{user: \App\Models\User, token: string}
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials do not match our records.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Revoke current access token for user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
