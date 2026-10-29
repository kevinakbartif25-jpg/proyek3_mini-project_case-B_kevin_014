<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\ReportController; // matikan dulu sementara
// use App\Http\Controllers\RekapController;  // matikan dulu sementara

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Ganti sementara pakai closure function biar ga manggil ReportController dulu
    Route::get('/dashboard', function () {
        return "Login Berhasil! Selamat datang, " . auth()->user()->nama_lengkap;
    })->name('dashboard');
});