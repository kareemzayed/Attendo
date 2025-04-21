<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Constructor function
     *
     * @param AuthService $authService
     */
    public function __construct(
        protected readonly AuthService $authService
    ) {}

    /**
     * Register new user function
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $userData = $this->authService->register($request->validated());

        return response()->json([
            'access_token' => $userData['token'],
            'token_type' => 'Bearer',
            'user' => $userData['user']->only(['id', 'name', 'email', 'phone'])
        ], 201);
    }
}
