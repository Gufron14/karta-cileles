<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'bencana_id',
        'judul',
        'isi',
        'slug',
        'thumbnail'
    ];

    public function bencana()
    {
        return $this->belongsTo(Bencana::class);
    }
}

