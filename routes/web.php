<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

    //route sementara
    Route::get('/reports/create', fn() => 'Halaman Create')->name('reports.create');
    Route::get('/reports/{report}', fn($id) => 'Halaman Detail ID: '.$id)->name('reports.show');
    Route::get('/reports/{report}/edit', fn($id) => 'Halaman Edit ID: '.$id)->name('reports.edit');
    Route::get('/rekap', fn() => 'Halaman Rekap')->name('rekap.index');
});