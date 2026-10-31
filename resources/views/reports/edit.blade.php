@extends('layout')
@section('title', 'Perbaiki Laporan')

@section('content')
<div class="card" style="max-width: 650px; margin: 0 auto;">
    <h2>Perbaiki Laporan Kebakaran</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 1rem;">
            <label><strong>Wilayah:</strong></label><br>
            <select name="area_id" style="width: 100%; padding: 8px;" required>
                @foreach($areas as $a)
                    <option value="{{ $a->id }}" {{ $report->area_id == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_area }} ({{ $a->kabupaten_kota }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Judul Laporan:</strong></label><br>
            <input type="text" name="judul" value="{{ old('judul', $report->judul) }}" style="width:100%; padding:8px; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Deskripsi:</strong></label><br>
            <textarea name="deskripsi" rows="4" style="width:100%; padding:8px; box-sizing:border-box;" required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
        </div>

        <div style="display:flex; gap: 10px; margin-bottom: 1rem;">
            <div style="flex:1;">
                <label><strong>Latitude:</strong></label><br>
                <input type="text" name="latitude" value="{{ old('latitude', $report->latitude) }}" style="width:100%; padding:8px; box-sizing:border-box;" required>
            </div>
            <div style="flex:1;">
                <label><strong>Longitude:</strong></label><br>
                <input type="text" name="longitude" value="{{ old('longitude', $report->longitude) }}" style="width:100%; padding:8px; box-sizing:border-box;" required>
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Waktu Kejadian:</strong></label><br>
            <input type="datetime-local" name="waktu_kejadian" value="{{ old('waktu_kejadian', $report->waktu_kejadian->format('Y-m-d\TH:i')) }}" style="width:100%; padding:8px; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label><strong>Ganti Bukti File (Opsional):</strong></label><br>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:10px;">Simpan Perubahan</button>
    </form>
</div>
@endsection