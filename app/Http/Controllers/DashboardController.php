<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use App\Models\JenisDana;
use App\Models\KasMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        $jenisDana = JenisDana::withSum('kasMasuk as saldo', 'nominal')->orderBy('id')->get();

        return view('dashboard.index', [
            'jenisDana' => $jenisDana,
            'totalSaldo' => (int) KasMasuk::sum('nominal'),
            'jumlahTransaksi' => KasMasuk::count(),
            'jumlahDonatur' => Donatur::count(),
        ]);
    }
}
