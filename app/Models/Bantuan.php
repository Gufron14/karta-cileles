<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bantuan extends Model
{
    protected $fillable = [
        'bencana_id',
        'jenis_bantuan',
        'jumlah',
        'satuan',
        'keterangan'
    ];

    public function bencana()
    {
        return $this->belongsTo(Bencana::class);
    }
}

