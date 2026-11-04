<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDana extends Model
{
    protected $table = 'jenis_dana';

    protected $fillable = ['nama'];

    public function kasMasuk()
    {
        return $this->hasMany(KasMasuk::class, 'jenis_dana_id');
    }
}
