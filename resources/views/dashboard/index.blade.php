@extends('layouts.app')
@section('judul', 'Beranda')
@section('content')
    <h2>Beranda</h2>
    <div class="grid">
        <div class="card stat"><span class="mut">Total saldo</span><b>{{ \App\Support\Fmt::rp($totalSaldo) }}</b></div>
        <div class="card stat"><span class="mut">Transaksi kas masuk</span><b>{{ $jumlahTransaksi }}</b></div>
        <div class="card stat"><span class="mut">Jamaah &amp; donatur</span><b>{{ $jumlahDonatur }}</b></div>
    </div>
    <div class="card">
        <h3>Saldo per jenis dana</h3>
        @forelse($jenisDana as $f)
            <div class="row"><span>{{ $f->nama }}</span><b>{{ \App\Support\Fmt::rp($f->saldo ?? 0) }}</b></div>
        @empty
            <p class="empty">Belum ada jenis dana.</p>
        @endforelse
    </div>
@endsection
