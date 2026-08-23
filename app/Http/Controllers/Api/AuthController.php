<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * @param  \App\Services\AuthService  $authService
     */
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Register a new user and issue an access token.
     *
     * @param  \App\Http\Requests\Auth\RegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->successResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
            'token_type' => 'Bearer',
        ], 'User registered successfully', Response::HTTP_CREATED);
    }

    /**
     * Authenticate a user and issue an access token.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return $this->successResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
            'token_type' => 'Bearer',
        ], 'User logged in successfully', Response::HTTP_OK);
    }

    /**
     * Log out authenticated user by revoking current access token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->successResponse(
            (object) [],
            'Logged out successfully',
            Response::HTTP_OK
        );
    }

    /**
     * Get the authenticated user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return $this->successResponse([
            'user' => new UserResource($request->user()),
        ], 'User profile retrieved successfully', Response::HTTP_OK);
    }
}
