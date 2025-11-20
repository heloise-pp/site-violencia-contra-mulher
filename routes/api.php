<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostController;

/*
 | --*------------------------------------------------------------------------
 | ROTAS PÚBLICAS
 |--------------------------------------------------------------------------
 */

// Rotas de Autenticação
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Rotas Públicas do Blog
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);


/*
 | --*------------------------------------------------------------------------
 | ROTAS PROTEGIDAS (Middleware auth:sanctum)
 |--------------------------------------------------------------------------
 */

Route::middleware('auth:sanctum')->group(function () {

    // Rota de Usuário Logado (Teste de Token)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rotas PROTEGIDAS do Blog (Criação, Edição, Exclusão)
    Route::post('posts', [PostController::class, 'store']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    // Rota de Logout
    Route::post('auth/logout', [AuthController::class, 'logout']);
});
