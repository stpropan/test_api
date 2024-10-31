<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// authorized user routes
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/profile', [UserController::class, 'profile']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);
