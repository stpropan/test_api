<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// authorized user routes
Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/profile', [UserController::class, 'profile']);
});

Route::post('/login', function (Request $request) {
    return $request->user();
});

Route::post('/register', function (Request $request) {
    return $request->user();
});
