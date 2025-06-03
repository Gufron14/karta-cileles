<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranPakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'p_laki',
        'p_perempuan',
        'p_anak',
        'tanggal',
        'status',
    ];

    
}
