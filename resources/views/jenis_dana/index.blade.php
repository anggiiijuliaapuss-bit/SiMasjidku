@extends('layouts.app')
@section('judul', 'Jenis Dana')
@section('content')
    <div class="bar"><h2>Jenis Dana</h2></div>

    <div class="card narrow">
        <form method="POST" action="{{ route('jenis-dana.store') }}">
            @csrf
            <label>Tambah jenis dana
                <input name="nama" value="{{ old('nama') }}" placeholder="Nama jenis dana">
            </label>
            <button class="btn">Tambah jenis dana</button>
        </form>
    </div>

    <div class="card tw">
        @if($daftar->count())
            <table>
                <thead><tr><th>Nama</th><th class="n">Saldo</th><th></th></tr></thead>
                <tbody>
                @foreach($daftar as $f)
                    <tr>
                        <td>{{ $f->nama }}</td>
                        <td class="n">{{ \App\Support\Fmt::rp($f->saldo ?? 0) }}</td>
                        <td class="ac">
                            <a class="btn sm ghost" href="{{ route('jenis-dana.edit', $f->id) }}">Ubah</a>
                            <form method="POST" action="{{ route('jenis-dana.destroy', $f->id) }}" onsubmit="return confirm('Hapus jenis dana ini?')">
                                @csrf @method('DELETE')
                                <button class="btn sm dng">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">Belum ada jenis dana.</p>
        @endif
    </div>
@endsection
