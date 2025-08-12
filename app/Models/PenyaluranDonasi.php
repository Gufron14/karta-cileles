<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyaluranDonasi extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'donasi_id',
        'tanggal',
        'uang_keluar',
        'alamat',
        'jml_kpl_keluarga',
        'nama_kk',
        'nomor_kk',
        'keterangan',
        'status'
    ];

//     public function donasi()
// {
//     return $this->belongsTo(Donasi::class, 'donasi_id');
// }

    protected $attributes = [
        'status' => 'pending'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'uang_keluar' => 'decimal:2',
        'nama_kk' => 'array',
        'nomor_kk' => 'array',
    ];

    // Accessor untuk format uang keluar
    public function getUangKeluarFormattedAttribute()
    {
        return 'Rp ' . number_format($this->uang_keluar, 0, ',', '.');
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter bulan
    public function scopeBulan($query, $bulan)
    {
        return $query->whereMonth('tanggal', $bulan);
    }

    // Scope untuk filter tahun
    public function scopeTahun($query, $tahun)
    {
        return $query->whereYear('tanggal', $tahun);
    }
}
