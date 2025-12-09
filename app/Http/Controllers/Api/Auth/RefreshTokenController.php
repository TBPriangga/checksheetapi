<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RefreshTokenController extends Controller
{
    /**
     * Refresh authentication token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Revoke old token
            $request->user()->currentAccessToken()->delete();

            // Generate new token
            $newToken = $user->createToken(
                name: 'auth_token',
                expiresAt: now()->addHours(24)
            )->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Token berhasil diperbarui.',
                'data' => [
                    'user' => new UserResource($user),
                    'token' => $newToken,
                    'token_type' => 'Bearer',
                    'expires_in' => 86400,
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('Token refresh error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui token.',
                'data' => null,
            ], 500);
        }
    }
}
