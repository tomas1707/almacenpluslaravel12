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
    /*Paso 6*/Route::put('/{id}', [ApiUserController::class, 'update']);
    /*Paso 6*/Route::patch('/{id}', [ApiUserController::class, 'partialUpdate']);
    /*Paso 7*/Route::delete('/{id}', [ApiUserController::class, 'destroy']);
});

Route::prefix('/proveedor')->group(function () {
    /*Paso 4*/Route::get('/', [ApiSupplierController::class, 'index']);
    /*Paso 4*/Route::get('/show', [ApiSupplierController::class, 'show']);
    /*Paso 5*/Route::post('/', [ApiSupplierController::class, 'store']);
    /*Paso 6*/Route::put('/{id}', [ApiSupplierController::class, 'update']);
    /*Paso 6*/Route::patch('/{id}', [ApiSupplierController::class, 'partialUpdate']);
    /*Paso 7*/Route::delete('/{id}', [ApiSupplierController::class, 'destroy']);
});
