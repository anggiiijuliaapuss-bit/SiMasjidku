@extends('layouts.app')
@section('judul', $item->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('content')
    <h2>{{ $item->exists ? 'Ubah pengguna' : 'Tambah pengguna' }}</h2>
    <div class="card narrow">
        <form method="POST" action="{{ $item->exists ? route('pengguna.update', $item->id) : route('pengguna.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <label>Nama
                <input name="nama" value="{{ old('nama', $item->nama) }}">
            </label>
            <label>Username
                <input name="username" autocomplete="off" value="{{ old('username', $item->username) }}">
            </label>
            <label>Peran
                <select name="role">
                    @foreach(['admin', 'bendahara'] as $r)
                        <option value="{{ $r }}" @selected(old('role', $item->role) === $r)>{{ $r }}</option>
                    @endforeach
                </select>
            </label>
            <label>Password{{ $item->exists ? ' (kosongkan jika tidak diubah)' : '' }}
                <input name="password" type="password" autocomplete="new-password">
            </label>
            <div class="act">
                <a class="btn ghost" href="{{ route('pengguna.index') }}">Batal</a>
                <button class="btn">Simpan</button>
            </div>
        </form>
    </div>
@endsection
