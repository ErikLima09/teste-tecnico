<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RelatorioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/cadastrar', [AuthController::class, 'cadastrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,     'logout']);
    Route::get('/perfil', [AuthController::class,     'perfil']);
    Route::get('/usuarios/{id}/produtos', [UsuarioController::class, 'showProducts']);

    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('produtos', ProdutoController::class);

    Route::get('/relatorio-sql', [RelatorioController::class, 'relatorio']);
});

