<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Auth, Hash, Password};
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\AuthRequests\{
    LoginRequest,
    RegisterRequest,
    ResetPassowrdRequest,
    UpdateProfileRequest,
    ForgetPasswordRequest,
    UpdatePasswordRequest
};

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
            'message' => __('messages.registration_successful'),
            'access_token' => $userData['token'],
            'token_type' => 'Bearer',
            'user' => $userData['user']->only(['id', 'name', 'email', 'phone'])
        ], 201);
    }

    /**
     * Login users function
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => __('messages.invalid_credentials'),
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => __('messages.login_successful'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->only(['id', 'name', 'email', 'phone']),
        ]);
    }

    /**
     * Logout user and revoke token
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => __('messages.logout_successful')
        ]);
    }

    /**
     * Get the authenticated user information.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'message' => __('messages.data_fetched_successfully'),
            'user' => $user,
        ]);
    }

    /**
     * Update the authenticated user's profile.
     *
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();

        $user->update($request->validated());

        return response()->json([
            'message' => __('messages.profile_updated'),
            'user' => $user,
        ]);
    }

    /**
     * Update the authenticated user's password.
     *
     * @param UpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => __('messages.password_change_successful'),
        ]);
    }

    /**
     * Send a password reset link to the user
     *
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function sendPasswordResetLink(ForgetPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __('messages.reset_link_sent')])
            : response()->json(['message' => __('messages.reset_link_failed')], 422);
    }

    /**
     * Reset the user's password
     *
     * @param ResetPassowrdRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPassowrdRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'token', 'password', 'password_confirmation'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __('messages.password_reset_successful')])
            : response()->json(['message' => __('messages.password_reset_failed')], 422);
    }
}
