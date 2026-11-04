@extends('layouts.app')
@section('judul', 'Pengguna')
@section('content')
    <div class="bar">
        <h2>Pengguna</h2>
        <a class="btn" href="{{ route('pengguna.create') }}">Tambah pengguna</a>
    </div>
    <div class="card tw">
        <table>
            <thead><tr><th>Nama</th><th>Username</th><th>Peran</th><th></th></tr></thead>
            <tbody>
            @foreach($daftar as $p)
                <tr>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->username }}</td>
                    <td><span class="tag">{{ $p->role }}</span></td>
                    <td class="ac">
                        <a class="btn sm ghost" href="{{ route('pengguna.edit', $p->id) }}">Ubah</a>
                        <form method="POST" action="{{ route('pengguna.destroy', $p->id) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn sm dng">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
