<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Angsuran extends Model
{
    protected $table = 'angsuran';

    protected $fillable = [
        'pinjaman_id',
        'tanggal_bayar',
        'jumlah_bayar',
    ];

    public function pinjaman(): BelongsTo
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }
}
