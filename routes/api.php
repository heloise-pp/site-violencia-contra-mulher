<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//rota de teste
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


use App\Http\Controllers\PostController;

Route::apiResource('posts', PostController::class);

//  rotas existentes (incluindo PostController)

use App\Http\Controllers\AuthController;


// ROTAS DE AUTENTICAÇÃO
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ROTAS PROTEGIDAS
Route::middleware('auth:sanctum')->group(function () {


    use App\Http\Controllers\PostController;


    Route::apiResource('posts', PostController::class)->except(['index', 'show']);



});

// rotas publicas
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);


