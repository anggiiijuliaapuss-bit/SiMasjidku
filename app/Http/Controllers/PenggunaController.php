<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index()
    {
        return view('pengguna.index', ['daftar' => User::orderBy('id')->get()]);
    }

    public function create()
    {
        return view('pengguna.form', ['item' => new User(['role' => 'bendahara'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna tersimpan.');
    }

    public function edit(int $id)
    {
        return view('pengguna.form', ['item' => User::findOrFail($id)]);
    }

    public function update(Request $request, int $id)
    {
        $item = User::findOrFail($id);
        $data = $this->validasi($request, $item);

        if ($item->role === 'admin' && $data['role'] !== 'admin' && User::where('role', 'admin')->count() < 2) {
            return back()->withErrors(['role' => 'Harus ada minimal satu admin.'])->withInput();
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $item->update($data);

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna tersimpan.');
    }

    public function destroy(Request $request, int $id)
    {
        $item = User::findOrFail($id);

        if ($item->id === $request->user()->id) {
            return back()->withErrors(['hapus' => 'Anda tidak dapat menghapus akun yang sedang dipakai.']);
        }

        if ($item->role === 'admin' && User::where('role', 'admin')->count() < 2) {
            return back()->withErrors(['hapus' => 'Harus ada minimal satu admin.']);
        }

        if ($item->kasMasuk()->exists()) {
            return back()->withErrors(['hapus' => 'Tidak dapat dihapus: pengguna ini sudah mencatat transaksi.']);
        }

        $item->delete();

        return redirect()->route('pengguna.index')->with('sukses', 'Pengguna dihapus.');
    }

    private function validasi(Request $request, ?User $item = null): array
    {
        $request->merge([
            'nama' => preg_replace('/\s+/', ' ', trim((string) $request->input('nama'))),
            'username' => strtolower(trim((string) $request->input('username'))),
        ]);

        return $request->validate([
            'nama' => ['required', 'min:3', 'max:100'],
            'username' => ['required', 'regex:/^[a-z0-9_.]{3,20}$/', Rule::unique('users', 'username')->ignore($item?->id)],
            'role' => ['required', Rule::in(['admin', 'bendahara'])],
            'password' => $item ? ['nullable', 'min:6'] : ['required', 'min:6'],
        ], [
            'nama.required' => 'Nama wajib diisi (minimal 3 karakter).',
            'nama.min' => 'Nama wajib diisi (minimal 3 karakter).',
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username 3–20 karakter: huruf kecil, angka, titik, atau garis bawah.',
            'username.unique' => 'Username sudah dipakai.',
            'role.in' => 'Peran tidak valid.',
            'password.required' => 'Password minimal 6 karakter.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);
    }
}
