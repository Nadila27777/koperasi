<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'no_anggota',
        'nik',
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_telepon',
        'tanggal_bergabung',
        'status',
    ];
}
