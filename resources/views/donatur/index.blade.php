@extends('layouts.app')
@section('judul', 'Jamaah & Donatur')
@section('content')
    @php($admin = auth()->user()->role === 'admin')
    <div class="bar">
        <h2>Jamaah &amp; Donatur</h2>
        @if($admin)
            <a class="btn" href="{{ route('donatur.create') }}">Tambah data</a>
        @endif
    </div>

    <form method="GET" action="{{ route('donatur.index') }}" class="filters">
        <input name="q" value="{{ $q }}" placeholder="Cari nama, no. HP, atau alamat" aria-label="Cari">
        <select name="tipe" aria-label="Tipe">
            <option value="">Semua tipe</option>
            <option value="Jamaah" @selected($tipe === 'Jamaah')>Jamaah</option>
            <option value="Donatur" @selected($tipe === 'Donatur')>Donatur</option>
        </select>
        <button class="btn ghost">Cari</button>
    </form>

    <div class="card tw">
        @if($daftar->count())
            <table>
                <thead><tr><th>Nama</th><th>Tipe</th><th>No. HP</th><th>Alamat</th><th></th></tr></thead>
                <tbody>
                @foreach($daftar as $d)
                    <tr>
                        <td>{{ $d->nama }}</td>
                        <td><span class="tag">{{ $d->tipe }}</span></td>
                        <td>{{ $d->hp ?: '–' }}</td>
                        <td>{{ $d->alamat ?: '–' }}</td>
                        <td class="ac">
                            @if($admin)
                                <a class="btn sm ghost" href="{{ route('donatur.edit', $d->id) }}">Ubah</a>
                                <form method="POST" action="{{ route('donatur.destroy', $d->id) }}" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn sm dng">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Data tidak ditemukan.{{ $admin ? ' Klik “Tambah data” untuk memulai.' : '' }}</p>
        @endif
    </div>
@endsection
