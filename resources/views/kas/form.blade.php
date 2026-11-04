@extends('layouts.app')
@section('judul', $item->exists ? 'Ubah Kas Masuk' : 'Catat Kas Masuk')
@section('content')
    <h2>{{ $item->exists ? 'Ubah kas masuk' : 'Catat kas masuk' }}</h2>
    <div class="card narrow">
        <form method="POST" action="{{ $item->exists ? route('kas.update', $item->id) : route('kas.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <label>Tanggal
                <input type="date" name="tanggal" value="{{ old('tanggal', \Illuminate\Support\Carbon::parse($item->tanggal)->format('Y-m-d')) }}">
            </label>
            <label>Jenis dana
                <select name="jenis_dana_id">
                    @foreach($jenisDana as $f)
                        <option value="{{ $f->id }}" @selected((string) old('jenis_dana_id', $item->jenis_dana_id) === (string) $f->id)>{{ $f->nama }}</option>
                    @endforeach
                </select>
            </label>
            <label>Donatur / sumber dana
                <select name="donatur_id">
                    <option value="">Tanpa nama (Hamba Allah)</option>
                    @foreach($donatur as $d)
                        <option value="{{ $d->id }}" @selected((string) old('donatur_id', $item->donatur_id) === (string) $d->id)>{{ $d->nama }} ({{ $d->tipe }})</option>
                    @endforeach
                </select>
            </label>
            <label>Nominal (Rp)
                <input name="nominal" inputmode="numeric" placeholder="50.000" value="{{ old('nominal', $item->nominal) }}">
            </label>
            <label>Keterangan
                <textarea name="keterangan" rows="2">{{ old('keterangan', $item->keterangan) }}</textarea>
            </label>
            <div class="act">
                <a class="btn ghost" href="{{ route('kas.index') }}">Batal</a>
                <button class="btn">Simpan</button>
            </div>
        </form>
    </div>
@endsection
