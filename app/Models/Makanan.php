<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_makanan',
        'jumlah_makanan',
        'satuan',
        'nama_donatur',
        'tanggal',
        'status',
    ];
}
