<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'pertanyaan',
        'jawaban'
    ];
}

