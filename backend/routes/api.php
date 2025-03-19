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
Route::post('/api/logout', [AuthController::class, 'logout']);

// USER
Route::get('/api/user', [UserController::class, 'getCurrentUser']);
Route::post('/api/user/onboarding', [UserController::class, 'finishUserOnboarding']);
Route::post('/api/user/edit', [UserController::class, 'updateUser']);
Route::post('/api/user/delete', [UserController::class, 'deleteUser']);


// MATCHES
Route::get('/api/match/get-potential-matches', [MatcherController::class, 'getPotentialMatches']);
Route::get('/api/match/get-matches', [MatcherController::class, 'getMatches']);
Route::post('/api/match/accept-match', [MatcherController::class, 'acceptMatch']);

//DEBUG
Route::get('/api/debug', [DebugController::class, 'debug']);
Route::post('/api/debug', [DebugController::class, 'debugPost']);

//ADMIN ENDPOINTS
Route::post('/api/admin/create-user', [UserAdminController::class, 'createUser']);
Route::post('/api/admin/update-user', [UserAdminController::class, 'updateUser']);
Route::post('/api/admin/delete-user', [UserAdminController::class, 'deleteUser']);
Route::get('/api/admin/users', [UserAdminController::class, 'getUsers']);
Route::get('/api/admin/user', [UserAdminController::class, 'getUser']);
Route::get('/api/admin/permissions', [UserAdminController::class, 'getAllSystemPermissions']);
