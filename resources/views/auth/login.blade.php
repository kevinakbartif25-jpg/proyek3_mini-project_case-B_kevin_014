<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Pemantauan Karhutla</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 340px; }
        .input-group { margin-bottom: 1rem; }
        .input-group label { display: block; margin-bottom: 4px; font-weight: bold; }
        .input-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background: #d9534f; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn:hover { background: #c9302c; }
        .error { color: red; font-size: 0.9em; margin-bottom: 1rem; }
        .demo-info { margin-top: 1.5rem; font-size: 0.85em; background: #eef2f7; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login Sistem Karhutla</h2>
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Masuk</button>
        </form>

        <div class="demo-info">
            <strong>Akun Demo (Password: password123):</strong><br>
            • Pelapor: <code>andi</code><br>
            • Relawan: <code>sari</code><br>
            • Koordinator: <code>budi</code>
        </div>
    </div>
</body>
</html>