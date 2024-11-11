<?php

use App\Http\Controllers\api\Daily_TaskController;
use App\Http\Controllers\api\KolamController;
use App\Http\Controllers\api\ModulController;
use App\Http\Controllers\api\PembelianPakanController;
use App\Http\Controllers\api\PenjualanIkanController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\KaryawanController;

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
    Route::post('/karyawan/import', [KaryawanController::class, 'import']);
    Route::get('/karyawan/export', [KaryawanController::class, 'export']);
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);
});