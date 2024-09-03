<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

/**
 * AuthService
 * 
 * This service handles user authentication, including registration, login, and logout.
 */
class AuthService
{

    /**
     * Register a new user and generate a JWT token.
     *
     * @param array $validateddata The validated user data.
     * @return array The response containing the user and JWT token.
     */
    public static function register($validateddata)
    {
        try {
            $user = User::create([
                'name' => $validateddata['name'],
                'email' => $validateddata['email'],
                'password' => Hash::make($validateddata['password']),
                'role' => $validateddata['role'],
            ]);
            $token = JWTAuth::fromUser($user);
            return [
                'success' => true,
                'data' => [
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer'
                    ]
                ]
            ];
        } catch (JWTException $exception) {
            return [
                'success' => false,
                'message' => 'An error occurred during authentication.',
                'status' => 500,
            ];
        }
    }

    /**
     * Authenticate a user and generate a JWT token.
     *
     * @param array $validateddata The validated user data.
     * @return array The response containing the user and JWT token or an error message.
     */

    public static function login($validatedData)
    {
        try {
            if (!$token = JWTAuth::attempt($validatedData)) {
                return [
                    'success' => false,
                    'message' => 'Unauthorized',
                    'status' => 401,
                ];
            }

            $user = JWTAuth::user();
            return [
                'success' => true,
                'data' => [
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer'
                    ]
                ]
            ];
        } catch (JWTException $exception) {
            return [
                'success' => false,
                'message' => 'An error occurred during authentication.',
                'status' => 500,
            ];
        }
    }

    /**
     * Logout the authenticated user.
     *
     * @return array The response indicating successful logout.
     */
    public static function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return [
                'success' => true,
                'message' => 'Successfully logged out',
            ];
        } catch (JWTException $exception) {
            return [
                'success' => false,
                'message' => 'Failed to logout, please try again',
                'status' => 500,
            ];
        }
    }
}
