<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk – SIMasjidKu</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main>
    <div class="lg card">
        <div class="logo">🕌</div>
        <h1>SIMasjidKu</h1>
        <p class="mut">Sistem Informasi Manajemen Masjid</p>
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
</body>
</html>
