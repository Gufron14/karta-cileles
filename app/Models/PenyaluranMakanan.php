<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranMakanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumlah',
        'alamat',
        'jml_kk',
        'nama_kk',  
        'tanggal',
        'status',
    ];

    protected $casts = [
        'nama_kk' => 'array'
    ];
}
