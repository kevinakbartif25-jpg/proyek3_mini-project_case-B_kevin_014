<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RekapController;  

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('layout');
    })->name('dashboard');

    //route sementara agar tombol di navbar tidak error
    Route::get('/reports/create', function () {
        return "Halaman Form Laporan (Segera Dibuat)";
    })->name('reports.create');

    Route::get('/rekap', function () {
        return "Halaman Rekap (Segera Dibuat)";
    })->name('rekap.index');
});