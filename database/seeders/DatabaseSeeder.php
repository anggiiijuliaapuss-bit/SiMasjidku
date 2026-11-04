<?php

namespace Database\Seeders;

use App\Models\JenisDana;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password awal; segera ganti lewat menu Pengguna atau atur di file .env
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make(env('SEED_ADMIN_PASSWORD', 'admin123')),
        ]);

        User::create([
            'nama' => 'Bendahara',
            'username' => 'bendahara',
            'role' => 'bendahara',
            'password' => Hash::make(env('SEED_BENDAHARA_PASSWORD', 'bendahara123')),
        ]);

        foreach (['Infaq', 'Zakat', 'Donasi', 'Operasional'] as $nama) {
            JenisDana::create(['nama' => $nama]);
        }
    }
}
