<?php

use App\Http\Controllers\Daily_TaskController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {


});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-manager', [AuthController::class, 'registerManager']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::resource('task', Daily_TaskController::class);
Route::resource('modul', ModulController::class);

