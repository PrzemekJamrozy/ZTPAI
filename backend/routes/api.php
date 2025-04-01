<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MatcherController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    "auth:sanctum",
])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
// USER
    Route::post('/user/onboarding', [UserController::class, 'finishUserOnboarding']);
    Route::apiResource('/user', UserController::class)->only(['show',"update","destroy"]);


// MATCHES
    Route::get('/match/get-potential-matches', [MatcherController::class, 'getPotentialMatches']);
    Route::get('/match/get-matches', [MatcherController::class, 'getMatches']);
    Route::post('/match/accept-match', [MatcherController::class, 'acceptMatch']);

    Route::get('/debug', [DebugController::class, 'debug']);
    Route::post('/debug', [DebugController::class, 'debugPost']);

//ADMIN ENDPOINTS
    Route::apiResource("/admin/user", UserAdminController::class);
    Route::get('/admin/permissions', [UserAdminController::class, 'getAllSystemPermissions']);
});

