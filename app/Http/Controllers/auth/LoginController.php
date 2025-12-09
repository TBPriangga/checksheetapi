<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Handle login API untuk Flutter
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $request->credentials();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.'
            ], 401);
        }

        $user = Auth::user();

        // Log login ke tabel logs
        Log::create([
            'user_id' => $user->id,
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Hapus token lama
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('flutter-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'data' => [
                'user' => [
                    'id'           => $user->id,
                    'name'         => $user->name,
                    'username'     => $user->username,
                    'email'        => $user->email,
                    'npk'          => $user->npk,
                    'dept_id'      => $user->dept_id,
                    'position_id'  => $user->position_id,
                    'department'   => $user->department?->name ?? null,
                    'position'     => $user->position?->position ?? null,
                    'detail_dept'  => $user->detail_department?->name ?? null,
                ],
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ]
        ]);
    }

    /**
     * Logout API
     */
    public function logout(): JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User belum login.'
        ], 401);
    }
}