@extends('layouts.app')
@section('judul', 'Kas Masuk')
@section('content')
    @php($bendahara = auth()->user()->role === 'bendahara')
    <div class="bar">
        <h2>Kas Masuk</h2>
        @if($bendahara)
            <a class="btn" href="{{ route('kas.create') }}">Catat kas masuk</a>
        @endif
    </div>

    <form method="GET" action="{{ route('kas.index') }}" class="filters">
        <label>Dari tanggal<input type="date" name="dari" value="{{ $dari }}"></label>
        <label>Sampai tanggal<input type="date" name="sampai" value="{{ $sampai }}"></label>
        <label>Jenis dana
            <select name="jenis_dana">
                <option value="">Semua</option>
                @foreach($jenisDana as $f)
                    <option value="{{ $f->id }}" @selected((string) $jenis === (string) $f->id)>{{ $f->nama }}</option>
                @endforeach
            </select>
        </label>
        <button class="btn ghost">Terapkan</button>
    </form>

    <div class="card tw">
        @if($daftar->count())
            <table>
                <thead>
                <tr><th>No.</th><th>Tanggal</th><th>Jenis dana</th><th>Sumber</th><th class="n">Nominal</th><th></th></tr>
                </thead>
                <tbody>
                @foreach($daftar as $k)
                    <tr>
                        <td>{{ $k->no }}</td>
                        <td>{{ \App\Support\Fmt::tgl($k->tanggal) }}</td>
                        <td>{{ $k->jenisDana->nama }}</td>
                        <td>{{ $k->donatur ? $k->donatur->nama : 'Hamba Allah' }}</td>
                        <td class="n">{{ \App\Support\Fmt::rp($k->nominal) }}</td>
                        <td class="ac">
                            <a class="btn sm ghost" href="{{ route('kas.bukti', $k->id) }}">Bukti</a>
                            @if($bendahara)
                                <a class="btn sm ghost" href="{{ route('kas.edit', $k->id) }}">Ubah</a>
                                <form method="POST" action="{{ route('kas.destroy', $k->id) }}" onsubmit="return confirm('Hapus transaksi ini? Saldo akan menyesuaikan otomatis.')">
                                    @csrf @method('DELETE')
                                    <button class="btn sm dng">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr><th colspan="4">Total (sesuai filter)</th><th class="n">{{ \App\Support\Fmt::rp($total) }}</th><th></th></tr>
                </tfoot>
            </table>
        @else
            <p class="empty">Belum ada transaksi pada filter ini.{{ $bendahara ? ' Klik “Catat kas masuk”.' : '' }}</p>
        @endif
    </div>
@endsection
