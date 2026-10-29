@extends('layout')
@section('title', 'Daftar Laporan Karhutla')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Daftar Laporan Kebakaran Hutan & Lahan</h2>
        @if(auth()->user()->role === 'pelapor')
            <a href="{{ route('reports.create') }}" class="btn btn-primary">+ Buat Laporan Baru</a>
        @endif
    </div>

    <!-- Filter & Search (AC-10 & AC-11) -->
    <form method="GET" action="{{ route('dashboard') }}" style="display:flex; gap:10px; margin: 1.5rem 0; flex-wrap:wrap;">
        <input type="text" name="search" placeholder="Cari judul laporan..." value="{{ request('search') }}" style="padding:6px; flex:1; min-width:180px;">
        
        <select name="status" style="padding:6px;">
            <option value="">-- Semua Status --</option>
            <option value="menunggu_peninjauan" {{ request('status') == 'menunggu_peninjauan' ? 'selected' : '' }}>Menunggu Peninjauan</option>
            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            <option value="diteruskan" {{ request('status') == 'diteruskan' ? 'selected' : '' }}>Diteruskan</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>

        <select name="area_id" style="padding:6px;">
            <option value="">-- Semua Wilayah --</option>
            @foreach($areas as $area)
                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nama_area }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('dashboard') }}" class="btn" style="background:#bbb; color:white;">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Wilayah / Area</th>
                <th>Judul Laporan</th>
                @if(auth()->user()->role !== 'pelapor')
                    <th>Pelapor</th>
                @endif
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $r)
                <tr>
                    <td>{{ $r->waktu_kejadian->format('d/m/Y H:i') }}</td>
                    <td>{{ $r->area->nama_area }}</td>
                    <td><strong>{{ $r->judul }}</strong></td>
                    @if(auth()->user()->role !== 'pelapor')
                        <td>{{ $r->user->nama_lengkap }}</td>
                    @endif
                    <td>
                        <span class="badge badge-{{ explode('_', $r->status)[0] }}">
                            {{ str_replace('_', ' ', strtoupper($r->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('reports.show', $r->id) }}" class="btn btn-primary" style="padding:4px 8px; font-size:0.8em;">Detail</a>
                        @if(auth()->user()->role === 'pelapor' && $r->status === 'menunggu_peninjauan')
                            <a href="{{ route('reports.edit', $r->id) }}" class="btn btn-warning" style="padding:4px 8px; font-size:0.8em;">Edit</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#888;">Tidak ada laporan yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $reports->links() }}
    </div>
</div>
@endsection