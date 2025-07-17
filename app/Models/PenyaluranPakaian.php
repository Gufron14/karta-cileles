<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranPakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pakaian_data',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'pakaian_data' => 'array',
    ];

    // Accessor untuk mendapatkan total pakaian laki-laki
    public function getPLakiAttribute()
    {
        return collect($this->pakaian_data)
            ->where('jenis', 'laki-laki')
            ->sum('jumlah');
    }

    // Accessor untuk mendapatkan total pakaian perempuan
    public function getPPerempuanAttribute()
    {
        return collect($this->pakaian_data)
            ->where('jenis', 'perempuan')
            ->sum('jumlah');
    }

    // Accessor untuk mendapatkan total pakaian anak
    public function getPAnakAttribute()
    {
        return collect($this->pakaian_data)
            ->where('jenis', 'anak')
            ->sum('jumlah');
    }

    // Accessor untuk mendapatkan total semua pakaian
    public function getTotalPakaianAttribute()
    {
        return collect($this->pakaian_data)->sum('jumlah');
    }
}
