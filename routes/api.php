<?php

use App\Http\Controllers\Daily_TaskController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembelianPakanController;
use App\Http\Controllers\PenjualanIkanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('task', Daily_TaskController::class);
    Route::resource('modul', ModulController::class);
    Route::resource('kolam', KolamController::class);
    Route::resource('pembelian_pakan', PembelianPakanController::class);
    Route::resource('penjualan_ikan', PenjualanIkanController::class);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-manager', [AuthController::class, 'registerManager']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
