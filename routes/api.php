<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiUserController;
use App\Http\Controllers\api\ApiAuthController;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});


//Route::prefix('/usuario')->middleware('auth:sanctum')->group(function () {
Route::prefix('/usuario')->group(function () {
    /*Paso 4*/Route::get('/', [ApiUserController::class, 'index']);
    /*Paso 4*/Route::get('/show', [ApiUserController::class, 'show']);
    /*Paso 5*/Route::post('/', [ApiUserController::class, 'store']);
    /*Paso 6*/Route::put('/{user}', [ApiUserController::class, 'update']);
    /*Paso 6*/Route::patch('/{user}', [ApiUserController::class, 'partialUpdate']);
    /*Paso 7*/Route::delete('/{user}', [ApiUserController::class, 'destroy']);
});
