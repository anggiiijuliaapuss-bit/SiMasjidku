@extends('layouts.app')
@section('judul', 'Ubah Jenis Dana')
@section('content')
    <h2>Ubah jenis dana</h2>
    <div class="card narrow">
        <form method="POST" action="{{ route('jenis-dana.update', $item->id) }}">
            @csrf @method('PUT')
            <label>Nama jenis dana
                <input name="nama" value="{{ old('nama', $item->nama) }}">
            </label>
            <div class="act">
                <a class="btn ghost" href="{{ route('jenis-dana.index') }}">Batal</a>
                <button class="btn">Simpan</button>
            </div>
        </form>
    </div>
@endsection
