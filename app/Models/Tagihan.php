<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'santri_id', 'user_id', 'angkatan', 'program',
        'tanggal_tagihan', 'tanggal_jatuh_tempo',
        'nama_biaya', 'jumlah_biaya', 'keterangan', 'denda', 'status'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
