<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


// Rotas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // ... rotas user e logout


    Route::post('posts', [PostController::class, 'store']); // Create
    Route::patch('posts/{post}', [PostController::class, 'update']); // Update
    Route::delete('posts/{post}', [PostController::class, 'destroy']); // Delete
});
