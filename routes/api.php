<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\LoginAJIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // Public Routes - Authentication
    Route::prefix('auth')->group(function () {
        Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');
        Route::post('/register', [RegisterController::class, 'register'])->name('api.auth.register');
    });

    // Protected Routes - Require Authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [LogoutController::class, 'logout'])->name('api.auth.logout');
            Route::get('/me', [MeController::class, 'me'])->name('api.auth.me');
            Route::post('/refresh-token', [RefreshTokenController::class, 'refresh'])->name('api.auth.refresh');
        });

        // Legacy routes - to be refactored
        Route::post('/updateDataAPI', [LoginAJIController::class, 'updateDataAPI'])->name('updateDataAPI');
    });
});

// Default user endpoint (deprecated - use /v1/auth/me instead)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
