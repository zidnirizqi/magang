<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\CategoryController;

// Auth API Routes
Route::post('/register', [AuthController::class, 'apiRegister']);
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

// Category API Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'apiIndex']);
    Route::get('/{id}', [CategoryController::class, 'apiShow']);
    Route::post('/', [CategoryController::class, 'apiStore']);
    Route::put('/{id}', [CategoryController::class, 'apiUpdate']);
    Route::delete('/{id}', [CategoryController::class, 'apiDestroy']);
    Route::patch('/{id}/toggle-status', [CategoryController::class, 'apiToggleStatus']);
});
