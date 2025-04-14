<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates= ['tanggal_bayar'];

    public function tagihan() {
        return $this->belongsTo(Pembayaran::class);
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
