<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Autenticação
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Blog público
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);


/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // usuário autenticado
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    // CRUD de posts
    Route::post('posts', [PostController::class, 'store']);
    Route::patch('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    // upload de imagem do editor
    Route::post('upload-image', [PostController::class, 'uploadImage']);

    // logout
    Route::post('auth/logout', [AuthController::class, 'logout']);
});