<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates= ['tanggal_bayar'];
    protected $with = ['user', 'tagihan'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function tagihanDetail()
    {
        return $this->hasManyThrough(TagihanDetail::class, Tagihan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
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
