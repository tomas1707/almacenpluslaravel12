<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RegisterController;
use App\Http\Controllers\api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


//Route::prefix('/usuario')->middleware('auth:sanctum')->group(function () {
Route::prefix('/usuario')->group(function () {
    /*Paso 4*/Route::get('/', [RegisterController::class, 'index']);
    /*Paso 4*/Route::get('/show', [RegisterController::class, 'show']);
    /*Paso 5*/Route::post('/', [RegisterController::class, 'store']);
    /*Paso 6*/Route::put('/{user}', [RegisterController::class, 'update']);
    /*Paso 6*/Route::patch('/{user}', [RegisterController::class, 'updatePartial']);
    /*Paso 7*/Route::delete('/{user}', [RegisterController::class, 'destroy']);
});
