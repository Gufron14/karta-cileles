<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bencana extends Model
{
    protected $fillable = [
        'nama_bencana',
        'lokasi',
        'tanggal_kejadian',
        'status',
        'deskripsi'
    ];

    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }

    public function dokumentasi()
    {
        return $this->hasMany(DokumentasiBencana::class);
    }

    public function bantuan()
    {
        return $this->hasMany(Bantuan::class);
    }
}

