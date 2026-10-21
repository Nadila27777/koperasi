<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'tanggal_simpanan',
        'jumlah',
        'jenis_simpanan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
