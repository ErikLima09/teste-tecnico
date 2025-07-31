<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/cadastrar', [AuthController::class, 'cadastrar']);
// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [AuthController::class, 'logout']);

//     Route::get('/produtos', [ProdutoController::class, 'index']);
//     Route::post('/produtos', [ProdutoController::class, 'store']);
//     Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
//     Route::put('/produtos/{id}', [ProdutoController::class, 'update']);
//     Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
// });