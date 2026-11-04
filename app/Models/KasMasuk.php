<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasMasuk extends Model
{
    protected $table = 'kas_masuk';

    protected $fillable = [
        'no', 'tanggal', 'jenis_dana_id', 'donatur_id', 'nominal', 'keterangan', 'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'nominal' => 'integer',
    ];

    public function jenisDana()
    {
        return $this->belongsTo(JenisDana::class, 'jenis_dana_id');
    }

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
