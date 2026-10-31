<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Area;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        if (!in_array(auth()->user()->role, ['relawan', 'koordinator'])) {
            abort(403, 'Akses terbatas untuk Relawan dan Koordinator.');
        }

        $totalSemuaLaporan = Report::count();
        $totalLaporanAktif = Report::whereIn('status', ['menunggu_peninjauan', 'diverifikasi', 'diteruskan'])->count();
        $totalLaporanSelesai = Report::where('status', 'selesai')->count();

        $queryAreas = Area::withCount([
            'reports',
            'reports as aktif_count' => fn($q) => $q->whereIn('status', ['menunggu_peninjauan', 'diverifikasi', 'diteruskan']),
            'reports as selesai_count' => fn($q) => $q->where('status', 'selesai'),
        ]);

        if ($request->filled('kabupaten')) {
            $queryAreas->where('kabupaten_kota', $request->kabupaten);
        }

        $rekapAreas = $queryAreas->get();
        $daftarKabupaten = Area::select('kabupaten_kota')->distinct()->pluck('kabupaten_kota');

        return view('rekap.index', compact(
            'totalSemuaLaporan',
            'totalLaporanAktif',
            'totalLaporanSelesai',
            'rekapAreas',
            'daftarKabupaten'
        ));
    }
}