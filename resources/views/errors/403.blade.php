<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses ditolak – SIMasjidKu</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main>
    <div class="card lg">
        <h2>Akses ditolak</h2>
        <p>{{ $exception->getMessage() ?: 'Peran Anda tidak memiliki izin untuk halaman ini.' }}</p>
        <p><a class="btn" href="{{ route('dashboard') }}">Kembali ke Beranda</a></p>
    </div>
</main>
</body>
</html>
