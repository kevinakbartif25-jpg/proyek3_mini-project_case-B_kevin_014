@extends('layout')
@section('title', 'Detail Laporan Karhutla')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>{{ $report->judul }}</h2>
        <span class="badge badge-{{ explode('_', $report->status)[0] }}" style="font-size:1em;">
            {{ str_replace('_', ' ', strtoupper($report->status)) }}
        </span>
    </div>

    <p style="color:#666;">
        Dilaporkan oleh: <strong>{{ $report->user->nama_lengkap }}</strong> | 
        Waktu: {{ $report->waktu_kejadian->format('d M Y H:i') }} | 
        Area: <strong>{{ $report->area->nama_area }}</strong> ({{ $report->area->kabupaten_kota }})
    </p>

    <hr>
    <h3>Kondisi yang Dilaporkan</h3>
    <p style="white-space: pre-line; background:#fafafa; padding:12px; border-radius:4px; border:1px solid #eee;">{{ $report->deskripsi }}</p>

    <p>
        <strong>Koordinat Lokasi:</strong> 
        Lat: <code>{{ $report->latitude }}</code>, Long: <code>{{ $report->longitude }}</code>
        <a href="https://maps.google.com/?q={{ $report->latitude }},{{ $report->longitude }}" target="_blank" style="margin-left:8px; font-size:0.9em;">[Buka di Google Maps]</a>
    </p>

    @if($report->bukti_path)
        <h3>Bukti Pendukung</h3>
        @if(str_ends_with(strtolower($report->bukti_path), '.pdf'))
            <a href="{{ asset('storage/' . $report->bukti_path) }}" target="_blank" class="btn btn-primary">Buka Dokumen PDF Bukti</a>
        @else
            <img src="{{ asset('storage/' . $report->bukti_path) }}" alt="Bukti Karhutla" style="max-width: 450px; border-radius: 6px; border: 1px solid #ccc;">
        @endif
    @endif

    <hr>
    <h3>Riwayat Tindak Lanjut & Catatan Peninjau</h3>
    @forelse($report->reviews as $rev)
        <div style="background:#f9f9f9; border-left:4px solid #2ecc71; padding:10px; margin-bottom:10px; border-radius:4px;">
            <strong>{{ $rev->user->nama_lengkap }} ({{ strtoupper($rev->user->role) }})</strong> - {{ $rev->created_at->format('d/m/Y H:i') }}<br>
            Perubahan status: <code>{{ $rev->status_sebelumnya }}</code> ➔ <strong>{{ $rev->status_baru }}</strong><br>
            Catatan: <em>"{{ $rev->catatan }}"</em>
        </div>
    @empty
        <p style="color:#888;">Belum ada catatan atau peninjauan untuk laporan ini.</p>
    @endforelse

    <!-- Form Aksi Peninjauan Relawan & Koordinator (AC-06 & AC-07) -->
    @if(in_array(auth()->user()->role, ['relawan', 'koordinator']))
        <hr>
        <div style="background:#fff3cd; padding:15px; border-radius:6px; border:1px solid #ffeeba;">
            <h3 style="margin-top:0;">Form Peninjauan ({{ strtoupper(auth()->user()->role) }})</h3>
            <form action="{{ route('reports.review', $report->id) }}" method="POST">
                @csrf
                <div style="margin-bottom:10px;">
                    <label><strong>Ubah Status Menjadi:</strong></label><br>
                    <select name="status_baru" style="padding:6px; width:100%; max-width:320px;" required>
                        @if(auth()->user()->role === 'relawan')
                            <option value="diverifikasi">Diverifikasi (Informasi Valid)</option>
                            <option value="ditolak">Ditolak (Informasi Palsu / Tidak Valid)</option>
                        @elseif(auth()->user()->role === 'koordinator')
                            <option value="diteruskan">Diteruskan (Ke BPBD / Damkar)</option>
                            <option value="selesai">Selesai (Penanganan Selesai)</option>
                        @endif
                    </select>
                </div>

                <div style="margin-bottom:10px;">
                    <label><strong>Catatan Peninjauan:</strong></label><br>
                    <textarea name="catatan" rows="3" style="width:100%; padding:6px; box-sizing:border-box;" placeholder="Tuliskan catatan hasil verifikasi lapangan atau instansi yang dihubungi..." required></textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan Tindak Lanjut</button>
            </form>
        </div>
    @endif
</div>
@endsection