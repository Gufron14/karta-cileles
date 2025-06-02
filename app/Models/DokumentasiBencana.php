<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiBencana extends Model
{
    protected $fillable = [
        'bencana_id',
        'jenis_media',
        'file_path',
        'keterangan'
    ];

    public function bencana()
    {
        return $this->belongsTo(Bencana::class);
    }
}

