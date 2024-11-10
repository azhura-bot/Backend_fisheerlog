<?php

use App\Http\Controllers\Daily_TaskController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\PembelianPakanController;
use App\Http\Controllers\PenjualanIkanController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

// Routes untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group routes yang memerlukan autentikasi Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('daily_task', Daily_TaskController::class);
    Route::resource('modul', ModulController::class);
    Route::resource('kolam', KolamController::class);
    Route::resource('pembelian_pakan', PembelianPakanController::class);
    Route::resource('penjualan_ikan', PenjualanIkanController::class);
});