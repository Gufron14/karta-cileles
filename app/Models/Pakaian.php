<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pakaian_data',
        'nama_donatur',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'pakaian_data' => 'array',
        'tanggal' => 'date',
    ];

    // Accessor untuk mendapatkan total jumlah pakaian
    public function getTotalJumlahAttribute()
    {
        if (!$this->pakaian_data) return 0;
        
        return collect($this->pakaian_data)->sum('jumlah');
    }

    // Accessor untuk mendapatkan jenis pakaian sebagai string
    public function getJenisPakaianStringAttribute()
    {
        if (!$this->pakaian_data) return '-';
        
        return collect($this->pakaian_data)
            ->map(function($item) {
                return $item['jenis'] . ' (' . $item['ukuran'] . ')';
            })
            ->join(', ');
    }
}
