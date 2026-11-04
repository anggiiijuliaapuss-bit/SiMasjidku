@extends('layouts.app')
@section('judul', $item->exists ? 'Ubah Data' : 'Tambah Data')
@section('content')
    <h2>{{ $item->exists ? 'Ubah data' : 'Tambah data' }}</h2>
    <div class="card narrow">
        <form method="POST" action="{{ $item->exists ? route('donatur.update', $item->id) : route('donatur.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <label>Tipe
                <select name="tipe">
                    @foreach(['Jamaah', 'Donatur'] as $t)
                        <option value="{{ $t }}" @selected(old('tipe', $item->tipe) === $t)>{{ $t }}</option>
                    @endforeach
                </select>
            </label>
            <label>Nama lengkap
                <input name="nama" value="{{ old('nama', $item->nama) }}">
            </label>
            <label>No. HP (opsional)
                <input name="hp" inputmode="tel" value="{{ old('hp', $item->hp) }}">
            </label>
            <label>Alamat (opsional)
                <textarea name="alamat" rows="2">{{ old('alamat', $item->alamat) }}</textarea>
            </label>
            <div class="act">
                <a class="btn ghost" href="{{ route('donatur.index') }}">Batal</a>
                <button class="btn">Simpan</button>
            </div>
        </form>
    </div>
@endsection
