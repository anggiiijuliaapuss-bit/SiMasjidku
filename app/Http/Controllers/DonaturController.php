<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $tipe = (string) $request->query('tipe', '');

        $daftar = Donatur::query()
            ->when($tipe !== '', fn ($query) => $query->where('tipe', $tipe))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('nama', 'like', "%{$q}%")
                        ->orWhere('hp', 'like', "%{$q}%")
                        ->orWhere('alamat', 'like', "%{$q}%");
                });
            })
            ->orderBy('nama')
            ->get();

        return view('donatur.index', ['daftar' => $daftar, 'q' => $q, 'tipe' => $tipe]);
    }

    public function create()
    {
        return view('donatur.form', ['item' => new Donatur(['tipe' => 'Donatur'])]);
    }

    public function store(Request $request)
    {
        Donatur::create($this->validasi($request));

        return redirect()->route('donatur.index')->with('sukses', 'Data tersimpan.');
    }

    public function edit(int $id)
    {
        return view('donatur.form', ['item' => Donatur::findOrFail($id)]);
    }

    public function update(Request $request, int $id)
    {
        $item = Donatur::findOrFail($id);
        $item->update($this->validasi($request, $id));

        return redirect()->route('donatur.index')->with('sukses', 'Data tersimpan.');
    }

    public function destroy(int $id)
    {
        $item = Donatur::findOrFail($id);

        if ($item->kasMasuk()->exists()) {
            return back()->withErrors(['hapus' => 'Tidak dapat dihapus: sudah dipakai pada transaksi.']);
        }

        $item->delete();

        return redirect()->route('donatur.index')->with('sukses', 'Data dihapus.');
    }

    private function validasi(Request $request, ?int $id = null): array
    {
        $request->merge([
            'nama' => preg_replace('/\s+/', ' ', trim((string) $request->input('nama'))),
            'hp' => trim((string) $request->input('hp')) ?: null,
            'alamat' => trim((string) $request->input('alamat')) ?: null,
        ]);

        return $request->validate([
            'tipe' => ['required', Rule::in(['Jamaah', 'Donatur'])],
            'nama' => [
                'required', 'min:3', 'max:150',
                Rule::unique('donatur', 'nama')
                    ->where(fn ($q) => $q->where('tipe', $request->input('tipe')))
                    ->ignore($id),
            ],
            'hp' => ['nullable', 'max:20', function ($atribut, $nilai, $gagal) {
                $bersih = preg_replace('/[\s-]/', '', (string) $nilai);
                if (! preg_match('/^(\+62|62|0)8\d{7,11}$/', $bersih)) {
                    $gagal('Format no. HP tidak valid (contoh 081234567890).');
                }
            }],
            'alamat' => ['nullable', 'max:255'],
        ], [
            'tipe.in' => 'Tipe tidak valid.',
            'nama.required' => 'Nama wajib diisi (minimal 3 karakter).',
            'nama.min' => 'Nama wajib diisi (minimal 3 karakter).',
            'nama.unique' => 'Data dengan nama dan tipe yang sama sudah ada.',
        ]);
    }
}
