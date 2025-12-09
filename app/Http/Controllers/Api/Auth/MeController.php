<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeController extends Controller
{
    /**
     * Get authenticated user information
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil diambil.',
                'data' => new UserResource($user),
            ], 200);

        } catch (\Exception $e) {
            Log::error('Get user error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pengguna.',
                'data' => null,
            ], 500);
        }
    }
}
