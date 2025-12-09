<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InspeksiAparController;
use App\Http\Controllers\Api\AparApiController;
use App\Http\Controllers\Api\ApiExportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::post('/login', [UserController::class, 'login']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // User
    Route::post('/logout', [UserController::class, 'logout']);
    
    // APAR Management
    Route::prefix('apar')->group(function () {
        Route::get('/', [AparApiController::class, 'index']);
        Route::get('/{id}', [AparApiController::class, 'show']);
        Route::post('/verify', [AparApiController::class, 'verify']);
        Route::post('/verify-apar', [InspeksiAparController::class, 'verify_mobile']);
        Route::get('/status/{status}', [AparApiController::class, 'byStatus']);
        Route::get('/area/{areaId}', [AparApiController::class, 'byArea']);
        Route::get('/{id}/history', [AparApiController::class, 'history']);
        Route::post('/{apar}/store-check', [InspeksiAparController::class, 'storeCheckApi']);
    });
    
    // Inspection
    Route::prefix('inspection')->group(function () {
        Route::get('/my-inspections', [AparApiController::class, 'myInspections']);
    });

    // EXPORT - Direct Download (Simple Version)
    Route::prefix('export')->middleware(['throttle:10,1'])->group(function () {
        
        // Export Laporan - Direct Download
        Route::post('/laporan', [ApiExportController::class, 'exportLaporan'])
            ->name('api.export.laporan');
        
        // Export Monitoring APAR - Direct Download
        Route::post('/monitoring-apar', [ApiExportController::class, 'exportMonitoringApar'])
            ->name('api.export.monitoring-apar');
        
        // Export by Patrol ID - Direct Download
        Route::post('/laporan-by-patrol', [ApiExportController::class, 'exportByPatrolId'])
            ->name('api.export.laporan-by-patrol');
        
        // Download Template - Direct Download
        Route::get('/template', [ApiExportController::class, 'downloadTemplate'])
            ->name('api.export.template');
    });
});