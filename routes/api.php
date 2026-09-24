<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - BAWASLU Management Asset System
|--------------------------------------------------------------------------
| Version: v1
*/

Route::prefix('v1')->group(function () {
    // Auth Endpoints
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Items & QR Scanner Endpoints
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/scan/{kode_bmn}', [ItemController::class, 'scan']);
    Route::get('/items/{item}', [ItemController::class, 'show']);
    Route::post('/items', [ItemController::class, 'store'])->middleware('auth');

    // Reports & Summary Endpoints
    Route::get('/reports/summary', [ReportController::class, 'summary']);
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reports', [ReportController::class, 'store'])->middleware('throttle:30,1');
});
