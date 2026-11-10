<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk – SIMasjidKu</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth">
<main>
    <div class="card login-card">
        <div class="brand">
            <img src="{{ asset('img/logo.png') }}" alt="SIMasjidKu – Sistem Informasi Manajemen Masjid/Musala Berbasis Web">
        </div>
        <h1>Masuk ke sistem</h1>
        <p class="mut sm">Silakan masuk dengan akun admin atau bendahara.</p>
        <form method="POST" action="{{ route('login.proses') }}">
            @csrf
            <label>Username
                <input name="username" value="{{ old('username') }}" autocomplete="username" autofocus>
            </label>
            <label>Password
                <input name="password" type="password" autocomplete="current-password">
            </label>
            @if($errors->any())
                <div class="errors" role="alert">
                    @foreach(array_unique($errors->all()) as $pesan)
                        <p>{{ $pesan }}</p>
                    @endforeach
                </div>
            @endif
            <button class="btn w">Masuk</button>
        </form>
    </div>
</main>
<footer class="auth-foot">Proyek Perangkat Lunak (Capstone Project) · STMIK El Rahma Yogyakarta</footer>
</body>
</html>
