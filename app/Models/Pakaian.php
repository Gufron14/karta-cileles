<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_pakaian',
        'jumlah_pakaian',
        'nama_donatur',
        'tanggal',
        'status',
    ];

}
