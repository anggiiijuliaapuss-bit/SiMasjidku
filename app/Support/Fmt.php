<?php

namespace App\Support;

use Carbon\Carbon;

class Fmt
{
    public static function rp($angka): string
    {
        return 'Rp ' . number_format((int) $angka, 0, ',', '.');
    }

    public static function tgl($tanggal): string
    {
        return Carbon::parse($tanggal)->locale('id')->translatedFormat('j F Y');
    }
}
