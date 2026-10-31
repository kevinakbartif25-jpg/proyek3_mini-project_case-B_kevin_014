@extends('layout')
@section('title', 'Buat Laporan Kebakaran')

@section('content')
<div class="card" style="max-width: 650px; margin: 0 auto;">
    <h2>Form Laporan Indikasi Karhutla</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1rem;">
            <label><strong>Pilih Wilayah / Area:</strong></label><br>
            <select name="area_id" id="area_select" style="width: 100%; padding: 8px; margin-top: 4px;" required>
                <option value="">-- Pilih Wilayah Pantauan --</option>
                @foreach($areas as $a)
                    <option value="{{ $a->id }}" data-lat="{{ $a->default_lat }}" data-long="{{ $a->default_long }}">
                        {{ $a->nama_area }} ({{ $a->kabupaten_kota }})
                    </option>
                @endforeach
            </select>
            <!-- Wadah Async Fetch Info (AC-09) -->
            <div id="area_info_box" style="display:none; margin-top:8px; padding:10px; background:#e8f4f8; border-left:4px solid #3498db; font-size:0.9em; border-radius:4px;"></div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Judul Laporan:</strong></label><br>
            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Titik api membakar lahan sawit" style="width:100%; padding:8px; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Deskripsi Kondisi:</strong></label><br>
            <textarea name="deskripsi" rows="4" style="width:100%; padding:8px; box-sizing:border-box;" placeholder="Jelaskan kondisi api, kepulan asap, arah angin, atau perkiraan luas..." required>{{ old('deskripsi') }}</textarea>
        </div>

        <div style="display:flex; gap: 10px; margin-bottom: 1rem;">
            <div style="flex:1;">
                <label><strong>Latitude:</strong></label><br>
                <input type="text" name="latitude" id="lat_input" value="{{ old('latitude') }}" placeholder="Rentang -11.0 s/d 6.0" style="width:100%; padding:8px; box-sizing:border-box;" required>
            </div>
            <div style="flex:1;">
                <label><strong>Longitude:</strong></label><br>
                <input type="text" name="longitude" id="long_input" value="{{ old('longitude') }}" placeholder="Rentang 95.0 s/d 141.0" style="width:100%; padding:8px; box-sizing:border-box;" required>
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label><strong>Waktu Kejadian Dilihat:</strong></label><br>
            <input type="datetime-local" name="waktu_kejadian" value="{{ old('waktu_kejadian', now()->format('Y-m-d\TH:i')) }}" style="width:100%; padding:8px; box-sizing:border-box;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label><strong>Bukti Pendukung (Foto / PDF, maks 2MB):</strong></label><br>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" style="margin-top:4px;">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; padding:10px; font-weight:bold;">Kirim Laporan</button>
    </form>
</div>

<!-- Script Asynchronous Fetch (AC-09) -->
<script>
    document.getElementById('area_select').addEventListener('change', function () {
        const areaId = this.value;
        const infoBox = document.getElementById('area_info_box');
        
        if (!areaId) {
            infoBox.style.display = 'none';
            return;
        }

        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.lat) {
            document.getElementById('lat_input').value = selectedOption.dataset.lat;
            document.getElementById('long_input').value = selectedOption.dataset.long;
        }

        // Interaksi Asynchronous via fetch()
        fetch(`/api/areas/${areaId}/stats`)
            .then(res => res.json())
            .then(data => {
                infoBox.style.display = 'block';
                infoBox.innerHTML = `📍 <strong>Informasi Area:</strong> Terdapat <strong>${data.active_reports}</strong> laporan aktif di wilayah ini. Total riwayat: ${data.total_reports} laporan.`;
            })
            .catch(() => {
                infoBox.style.display = 'none';
            });
    });
</script>
@endsection