<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'nama_anggota',
        'jenis_simpanan',
        'jumlah',
        'tanggal_simpanan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
