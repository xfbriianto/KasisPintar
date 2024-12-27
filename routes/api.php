<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Menggunakan apiResource untuk rute barang
Route::apiResource('barang', BarangController::class);

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 
'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 
'login']);
Route::get('/barang', [\App\Http\Controllers\BooksController::class, 'index'])->middleware('auth:sanctum');
Route::post('/barang', [\App\Http\Controllers\BooksController::class, 'store'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);});


