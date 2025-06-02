<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Relawan extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'no_hp',
        'email',
        'alamat',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan_terakhir',
        'usia',
        'ketertarikan',
        'kegiatan',
        'dokumentasi',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Accessor untuk format tanggal lahir
    public function getTanggalLahirFormattedAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->format('d F Y') : '-';
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => 'success',
            'pasif' => 'secondary',
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
