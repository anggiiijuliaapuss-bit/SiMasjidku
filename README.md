# SIMasjidKu – Berkas Sprint 1 (Laravel 10, PHP 8.1, MySQL)

Isi paket ini: login + peran (PB-01), jenis dana & pengguna (PB-02), data jamaah/donatur (PB-03),
kas masuk (PB-04) dan saldo otomatis + bukti setoran (PB-05).

## Cara memasang
1. Salin **seluruh isi** folder ini ke `C:\laragon\www\simasjidku`. Jika Windows menanyakan,
   pilih **Replace/Timpa**. Ada satu berkas bawaan yang ikut tertimpa:
   `database/migrations/2014_10_12_000000_create_users_table.php` (kolom `nama`, `username`, `role`).
2. (Opsional) tambahkan nama masjid di akhir file `.env`:
   ```
   MASJID_NAMA="Masjid Al-Ikhlas"
   ```
3. Buka terminal Laragon di folder proyek, lalu jalankan:
   ```
   php artisan config:clear
   php artisan migrate:fresh --seed
   php artisan serve
   ```
   `migrate:fresh` menghapus semua tabel lalu membuatnya ulang (aman karena belum ada data).
4. Buka http://127.0.0.1:8000 dan masuk dengan akun awal:

   | Username | Password | Peran |
   |---|---|---|
   | admin | admin123 | admin |
   | bendahara | bendahara123 | bendahara |

   **Ganti password ini** lewat menu Pengguna sebelum dipakai di luar uji coba.

## Hak akses (sesuai Tabel 2.3 proposal)
| Fitur | Admin | Bendahara |
|---|---|---|
| Beranda (saldo per jenis dana) | lihat | lihat |
| Jamaah & Donatur | tambah, ubah, hapus, cari | lihat dan cari |
| Kas Masuk | lihat, cetak bukti | catat, ubah, hapus, cetak bukti |
| Jenis Dana, Pengguna | kelola | tidak ada akses |

Pembatasan dijalankan di server (middleware `RoleMiddleware`), bukan hanya menyembunyikan menu.

## Daftar berkas
- `routes/web.php` – semua rute dan pembatasan peran
- `app/Http/Middleware/RoleMiddleware.php`
- `app/Http/Controllers/*` – Auth, Dashboard, JenisDana, Pengguna, Donatur, KasMasuk
- `app/Models/*` – User, JenisDana, Donatur, KasMasuk
- `app/Support/Fmt.php` – format rupiah dan tanggal
- `config/masjid.php` – nama masjid untuk bukti setoran
- `database/migrations/*` – users, jenis_dana, donatur, kas_masuk
- `database/seeders/DatabaseSeeder.php` – akun awal dan 4 jenis dana
- `resources/views/*` dan `public/css/app.css` – tampilan

## Daftar cek sebelum Sprint Review
- [ ] Login admin dan bendahara berhasil; password salah ditolak; 5 kali salah dikunci sementara
- [ ] Bendahara membuka `/pengguna` atau `/jenis-dana` -> "Akses ditolak"
- [ ] Admin tidak melihat tombol "Catat kas masuk"; bendahara tidak melihat tombol Tambah/Ubah/Hapus pada Jamaah & Donatur
- [ ] Nama dan tipe yang sama ditolak (tidak ada duplikat)
- [ ] Nominal kosong, 0, atau negatif ditolak; donasi tanpa donatur tercatat sebagai "Hamba Allah"
- [ ] Nomor transaksi otomatis KM-00001, KM-00002, ...; saldo di Beranda ikut berubah
- [ ] Jenis dana, donatur, atau pengguna yang sudah dipakai transaksi tidak bisa dihapus
- [ ] Bukti setoran bisa dicetak

## Catatan
- Daftar transaksi dan donatur belum memakai paginasi (cukup untuk Sprint 1).
- Tanggal bawaan formulir kas memakai zona waktu Asia/Jakarta.
- Untuk Git: satu cabang per fitur (mis. `fitur/login`, `fitur/kas-masuk`), lalu *pull request* ke `main`
  sesuai Definition of Done.
