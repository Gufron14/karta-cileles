<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    // Hapus baris ini: public $timestamps = false;
    
    protected $fillable = [
        'nama_donatur',
        'kode_transaksi',
        'email',
        'no_hp',
        'catatan',
        'nominal',
        'bukti_transfer',
        'status'
    ];

//     public function penyalurans()
// {
//     return $this->hasMany(PenyaluranDonasi::class, 'donasi_id');
// }

    protected $attributes = [
        'status' => 'pending'
    ];

    // Accessor untuk format nominal
    public function getNominalFormattedAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter bulan
    public function scopeBulan($query, $bulan)
    {
        return $query->whereMonth('created_at', $bulan);
    }

    // Scope untuk filter tahun
    public function scopeTahun($query, $tahun)
    {
        return $query->whereYear('created_at', $tahun);
    }
}
