@extends('layout')
@section('title', 'Rekapitulasi Data Karhutla')

@section('content')
<div class="card">
    <h2>Rekapitulasi Data Kebakaran Hutan dan Lahan</h2>

    <!-- 3 Informasi Ringkasan Sederhana (AC-13) -->
    <div style="display:flex; gap:15px; margin-bottom: 2rem; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px; background:#e8f4f8; padding:15px; border-radius:8px; border-left:5px solid #3498db;">
            <div style="font-size:0.9em; color:#555;">Total Seluruh Laporan</div>
            <div style="font-size:1.8em; font-weight:bold;">{{ $totalSemuaLaporan }}</div>
        </div>
        <div style="flex:1; min-width:200px; background:#fef9e7; padding:15px; border-radius:8px; border-left:5px solid #f1c40f;">
            <div style="font-size:0.9em; color:#555;">Laporan Masih Aktif</div>
            <div style="font-size:1.8em; font-weight:bold;">{{ $totalLaporanAktif }}</div>
        </div>
        <div style="flex:1; min-width:200px; background:#eafaf1; padding:15px; border-radius:8px; border-left:5px solid #2ecc71;">
            <div style="font-size:0.9em; color:#555;">Laporan Selesai</div>
            <div style="font-size:1.8em; font-weight:bold;">{{ $totalLaporanSelesai }}</div>
        </div>
    </div>

    <!-- Filter Kabupaten (AC-13) -->
    <form method="GET" action="{{ route('rekap.index') }}" style="margin-bottom:1rem; display:flex; gap:10px;">
        <select name="kabupaten" style="padding:6px;">
            <option value="">-- Semua Kabupaten / Kota --</option>
            @foreach($daftarKabupaten as $kab)
                <option value="{{ $kab }}" {{ request('kabupaten') == $kab ? 'selected' : '' }}>{{ $kab }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter Rekap</button>
        <a href="{{ route('rekap.index') }}" class="btn" style="background:#bbb; color:white;">Reset</a>
    </form>

    <!-- Tabel Rekapitulasi per Wilayah -->
    <table>
        <thead>
            <tr>
                <th>Nama Area / Wilayah</th>
                <th>Kabupaten / Kota</th>
                <th>Total Laporan</th>
                <th>Laporan Aktif</th>
                <th>Laporan Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekapAreas as $area)
                <tr>
                    <td><strong>{{ $area->nama_area }}</strong></td>
                    <td>{{ $area->kabupaten_kota }}</td>
                    <td>{{ $area->reports_count }}</td>
                    <td><span class="badge badge-menunggu">{{ $area->aktif_count }}</span></td>
                    <td><span class="badge badge-diverifikasi">{{ $area->selesai_count }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection