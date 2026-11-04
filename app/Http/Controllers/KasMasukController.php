<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use App\Models\JenisDana;
use App\Models\KasMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasMasukController extends Controller
{
    public function index(Request $request)
    {
        $dari = (string) $request->query('dari', '');
        $sampai = (string) $request->query('sampai', '');
        $jenis = (string) $request->query('jenis_dana', '');

        $daftar = KasMasuk::with(['jenisDana', 'donatur'])
            ->when($dari !== '', fn ($q) => $q->whereDate('tanggal', '>=', $dari))
            ->when($sampai !== '', fn ($q) => $q->whereDate('tanggal', '<=', $sampai))
            ->when($jenis !== '', fn ($q) => $q->where('jenis_dana_id', $jenis))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('kas.index', [
            'daftar' => $daftar,
            'total' => (int) $daftar->sum('nominal'),
            'jenisDana' => JenisDana::orderBy('id')->get(),
            'dari' => $dari,
            'sampai' => $sampai,
            'jenis' => $jenis,
        ]);
    }

    public function create()
    {
        $item = new KasMasuk([
            'tanggal' => Carbon::now('Asia/Jakarta')->toDateString(),
        ]);

        return view('kas.form', $this->dataForm($item));
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['dicatat_oleh'] = $request->user()->id;

        DB::transaction(function () use ($data) {
            $kas = KasMasuk::create($data);
            $kas->update(['no' => 'KM-' . str_pad((string) $kas->id, 5, '0', STR_PAD_LEFT)]);
        });

        return redirect()->route('kas.index')->with('sukses', 'Transaksi tersimpan.');
    }

    public function edit(int $id)
    {
        return view('kas.form', $this->dataForm(KasMasuk::findOrFail($id)));
    }

    public function update(Request $request, int $id)
    {
        $kas = KasMasuk::findOrFail($id);
        $kas->update($this->validasi($request));

        return redirect()->route('kas.index')->with('sukses', 'Transaksi tersimpan.');
    }

    public function destroy(int $id)
    {
        KasMasuk::findOrFail($id)->delete();

        return redirect()->route('kas.index')->with('sukses', 'Transaksi dihapus.');
    }

    public function bukti(int $id)
    {
        $kas = KasMasuk::with(['jenisDana', 'donatur', 'pencatat'])->findOrFail($id);

        return view('kas.bukti', ['kas' => $kas]);
    }

    private function dataForm(KasMasuk $item): array
    {
        return [
            'item' => $item,
            'jenisDana' => JenisDana::orderBy('id')->get(),
            'donatur' => Donatur::orderBy('nama')->get(),
        ];
    }

    private function validasi(Request $request): array
    {
        // "50.000" -> 50000 ; "1,5" -> 1.5
        $mentah = trim((string) $request->input('nominal'));
        $angka = str_replace(',', '.', str_replace('.', '', $mentah));
        $request->merge([
            'nominal_angka' => $angka,
            'donatur_id' => $request->input('donatur_id') ?: null,
            'keterangan' => trim((string) $request->input('keterangan')) ?: null,
        ]);

        $valid = $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_dana_id' => ['required', 'exists:jenis_dana,id'],
            'donatur_id' => ['nullable', 'exists:donatur,id'],
            'nominal_angka' => ['required', 'numeric', 'gt:0', 'max:1000000000000'],
            'keterangan' => ['nullable', 'max:1000'],
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'jenis_dana_id.required' => 'Jenis dana wajib dipilih.',
            'jenis_dana_id.exists' => 'Jenis dana tidak valid.',
            'donatur_id.exists' => 'Donatur tidak valid.',
            'nominal_angka.required' => 'Nominal harus berupa angka lebih dari 0.',
            'nominal_angka.numeric' => 'Nominal harus berupa angka lebih dari 0.',
            'nominal_angka.gt' => 'Nominal harus berupa angka lebih dari 0.',
            'nominal_angka.max' => 'Nominal terlalu besar.',
        ]);

        return [
            'tanggal' => $valid['tanggal'],
            'jenis_dana_id' => (int) $valid['jenis_dana_id'],
            'donatur_id' => ! empty($valid['donatur_id']) ? (int) $valid['donatur_id'] : null,
            'nominal' => (int) round((float) $valid['nominal_angka']),
            'keterangan' => $valid['keterangan'] ?? null,
        ];
    }
}
