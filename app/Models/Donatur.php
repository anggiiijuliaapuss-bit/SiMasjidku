<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    protected $table = 'donatur';

    protected $fillable = ['tipe', 'nama', 'hp', 'alamat'];

    public function kasMasuk()
    {
        return $this->hasMany(KasMasuk::class, 'donatur_id');
    }
}
