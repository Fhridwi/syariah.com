<?php

namespace App\Models;

use Dom\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{

    protected $guarded = [];
    protected $dates = ['tanggal_tagihan', 'tanggal_jatuh_tempo'];
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

    // Ganti jadi
public function tagihanDetail()
{
    return $this->hasOne(TagihanDetail::class);
}

public function TagihanDetails()
{
    return $this->hasMany(TagihanDetail::class);
}
public function Pembayaran()
{
    return $this->hasMany(Pembayaran::class);
}


    protected static function booted()
{
    static::creating(function($biaya) {
        $biaya->user_id = auth()->user()->id;
    });

    static::updating(function($biaya) {
        $biaya->user_id = auth()->user()->id;
    });
}

}
