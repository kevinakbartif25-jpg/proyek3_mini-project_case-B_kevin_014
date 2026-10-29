<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Karhutla')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f8fafc; color: #333; }
        nav { background: #2c3e50; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: white; text-decoration: none; margin-left: 15px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
        .btn { padding: 8px 14px; border-radius: 4px; text-decoration: none; font-size: 0.9em; cursor: pointer; border: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #2ecc71; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-warning { background: #f39c12; color: white; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; font-weight: bold; }
        .badge-menunggu { background: #f1c40f; color: #333; }
        .badge-diverifikasi { background: #2ecc71; color: white; }
        .badge-ditolak { background: #e74c3c; color: white; }
        .badge-diteruskan { background: #3498db; color: white; }
        .badge-selesai { background: #95a5a6; color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        table th, table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    @auth
    <nav>
        <div>
            <strong>Pantau Karhutla</strong> | Role: <span style="text-transform: uppercase; color: #f1c40f;">{{ auth()->user()->role }}</span> ({{ auth()->user()->nama_lengkap }})
        </div>
        <div>
            <a href="{{ route('dashboard') }}">Dashboard Laporan</a>
            @if(auth()->user()->role === 'pelapor')
                <a href="{{ route('reports.create') }}">+ Buat Laporan</a>
            @endif
            @if(in_array(auth()->user()->role, ['relawan', 'koordinator']))
                <a href="{{ route('rekap.index') }}">Rekap Data</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left: 15px;">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 4px 10px;">Logout</button>
            </form>
        </div>
    </nav>
    @endauth

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>