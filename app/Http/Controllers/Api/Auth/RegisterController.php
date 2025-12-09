<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Handle user registration
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            // Validate input
            $validated = $request->validated();

            // Check if user already exists
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.',
                    'data' => null,
                ], 409);
            }

            // Create new user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => $validated['password'],
                'role' => 'user',
                'is_active' => true,
            ]);

            // Generate API token
            $token = $user->createToken(
                name: 'auth_token',
                expiresAt: now()->addHours(24)
            )->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil. Silakan login.',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => 86400,
                ],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pendaftaran.',
                'data' => null,
            ], 500);
        }
    }
}
