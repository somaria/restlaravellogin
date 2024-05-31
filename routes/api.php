<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/user', 'userProfile')->middleware('auth:sanctum');
    Route::get('/logout', 'logout')->middleware('auth:sanctum');
});
