<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MatcherController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);

Route::middleware([
    "auth:sanctum",
])->group(function () {
    Route::post('/api/logout', [AuthController::class, 'logout']);

// USER
    Route::post('/api/user/onboarding', [UserController::class, 'finishUserOnboarding']);
    Route::apiResource('/api/user', UserController::class)->only(['show',"update","destroy"]);


// MATCHES
    Route::get('/api/match/get-potential-matches', [MatcherController::class, 'getPotentialMatches']);
    Route::get('/api/match/get-matches', [MatcherController::class, 'getMatches']);
    Route::post('/api/match/accept-match', [MatcherController::class, 'acceptMatch']);

    Route::get('/api/debug', [DebugController::class, 'debug']);
    Route::post('/api/debug', [DebugController::class, 'debugPost']);

//ADMIN ENDPOINTS
    Route::apiResource("/api/admin/user", UserAdminController::class);
    Route::get('/api/admin/permissions', [UserAdminController::class, 'getAllSystemPermissions']);
});

