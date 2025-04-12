<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Santri extends Model
{
    use HasFactory;
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nis' => 10,
        
        ],
    ];


    protected $fillable = [
        'nama',
        'nis',
        'program',
        'angkatan',
        'wali_status',
        'wali_id',
        'user_id',
        'foto'
    ];
public function wali()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


    
}
