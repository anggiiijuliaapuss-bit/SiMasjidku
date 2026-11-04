<?php

namespace App\Http\Controllers;

use App\Models\JenisDana;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisDanaController extends Controller
{
    public function index()
    {
        $daftar = JenisDana::withSum('kasMasuk as saldo', 'nominal')->orderBy('id')->get();

        return view('jenis_dana.index', ['daftar' => $daftar]);
    }

    public function store(Request $request)
    {
        JenisDana::create($this->validasi($request));

        return redirect()->route('jenis-dana.index')->with('sukses', 'Jenis dana tersimpan.');
    }

    public function edit(int $id)
    {
        return view('jenis_dana.edit', ['item' => JenisDana::findOrFail($id)]);
    }

    public function update(Request $request, int $id)
    {
        $item = JenisDana::findOrFail($id);
        $item->update($this->validasi($request, $id));

        return redirect()->route('jenis-dana.index')->with('sukses', 'Jenis dana tersimpan.');
    }

    public function destroy(int $id)
    {
        $item = JenisDana::findOrFail($id);

        if ($item->kasMasuk()->exists()) {
            return back()->withErrors(['hapus' => 'Tidak dapat dihapus: sudah dipakai pada transaksi.']);
        }

        $item->delete();

        return redirect()->route('jenis-dana.index')->with('sukses', 'Jenis dana dihapus.');
    }

    private function validasi(Request $request, ?int $id = null): array
    {
        $request->merge(['nama' => preg_replace('/\s+/', ' ', trim((string) $request->input('nama')))]);

        return $request->validate([
            'nama' => ['required', 'min:3', 'max:100', Rule::unique('jenis_dana', 'nama')->ignore($id)],
        ], [
            'nama.required' => 'Nama wajib diisi (minimal 3 karakter).',
            'nama.min' => 'Nama wajib diisi (minimal 3 karakter).',
            'nama.unique' => 'Jenis dana dengan nama ini sudah ada.',
        ]);
    }
}
