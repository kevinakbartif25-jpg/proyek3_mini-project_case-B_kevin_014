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

    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    //ac-09
    Route::get('/api/areas/{area}/stats', function (\App\Models\Area $area) {
        $activeReports = $area->reports()
            ->whereIn('status', ['menunggu_peninjauan', 'diverifikasi', 'diteruskan'])
            ->count();

        return response()->json([
            'nama_area'      => $area->nama_area,
            'active_reports' => $activeReports,
            'total_reports'  => $area->reports()->count(),
        ]);
    });
    Route::get('/reports/{report}', fn($id) => 'Halaman Detail ID: '.$id)->name('reports.show');
    Route::get('/reports/{report}/edit', fn($id) => 'Halaman Edit ID: '.$id)->name('reports.edit');
    Route::get('/rekap', fn() => 'Halaman Rekap')->name('rekap.index');
});