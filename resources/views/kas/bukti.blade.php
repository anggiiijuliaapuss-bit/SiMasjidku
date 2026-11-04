@extends('layouts.app')
@section('judul', 'Bukti Setoran')
@section('content')
    <h2>Bukti setoran</h2>
    <div class="card narrow">
        <div id="receipt">
            <h3 class="c">{{ config('masjid.nama') }}</h3>
            <p class="c mut sm">Bukti setoran kas masuk</p>
            <div class="row"><span class="mut">No. transaksi</span><b>{{ $kas->no }}</b></div>
            <div class="row"><span class="mut">Tanggal</span><b>{{ \App\Support\Fmt::tgl($kas->tanggal) }}</b></div>
            <div class="row"><span class="mut">Jenis dana</span><b>{{ $kas->jenisDana->nama }}</b></div>
            <div class="row"><span class="mut">Sumber dana</span><b>{{ $kas->donatur ? $kas->donatur->nama : 'Hamba Allah' }}</b></div>
            <div class="row"><span class="mut">Nominal</span><b>{{ \App\Support\Fmt::rp($kas->nominal) }}</b></div>
            <div class="row"><span class="mut">Keterangan</span><b>{{ $kas->keterangan ?: '–' }}</b></div>
            <div class="row"><span class="mut">Dicatat oleh</span><b>{{ $kas->pencatat->nama }}</b></div>
        </div>
        <div class="act">
            <a class="btn ghost" href="{{ route('kas.index') }}">Kembali</a>
            <button type="button" class="btn" onclick="window.print()">Cetak</button>
        </div>
    </div>
@endsection
