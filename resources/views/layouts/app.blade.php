<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Beranda') – SIMasjidKu</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@php($u = auth()->user())
<header class="top">
    <b>🕌 SIMasjidKu</b>
    <span class="sp"></span>
    <span class="sm">{{ $u->nama }} ({{ $u->role }})</span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn ghost sm">Keluar</button>
    </form>
</header>
<nav>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'on' : '' }}">Beranda</a>
    <a href="{{ route('donatur.index') }}" class="{{ request()->routeIs('donatur.*') ? 'on' : '' }}">Jamaah &amp; Donatur</a>
    <a href="{{ route('kas.index') }}" class="{{ request()->routeIs('kas.*') ? 'on' : '' }}">Kas Masuk</a>
    @if($u->role === 'admin')
        <a href="{{ route('jenis-dana.index') }}" class="{{ request()->routeIs('jenis-dana.*') ? 'on' : '' }}">Jenis Dana</a>
        <a href="{{ route('pengguna.index') }}" class="{{ request()->routeIs('pengguna.*') ? 'on' : '' }}">Pengguna</a>
    @endif
</nav>
<main>
    @if(session('sukses'))
        <div class="flash" role="status">{{ session('sukses') }}</div>
    @endif
    @if($errors->any())
        <div class="errors" role="alert">
            @foreach(array_unique($errors->all()) as $pesan)
                <p>{{ $pesan }}</p>
            @endforeach
        </div>
    @endif

    @yield('content')
</main>
<script>
    // Cegah klik ganda saat formulir dikirim
    document.addEventListener('submit', function (e) {
        if (e.defaultPrevented) return;
        var b = e.target.querySelector('button:not([type=button])');
        if (b) setTimeout(function () { b.disabled = true; }, 0);
    });
</script>
</body>
</html>
