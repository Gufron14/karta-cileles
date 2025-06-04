<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'bencana_id',
        'judul',
        'isi',
        'slug', // tambahkan field ini
        'thumbnail', // tambahkan field ini
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bencana()
    {
        return $this->belongsTo(Bencana::class);
    }

    // Auto generate slug dari judul
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            if (empty($berita->slug)) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
        
        static::updating(function ($berita) {
            if ($berita->isDirty('judul')) {
                $berita->slug = Str::slug($berita->judul);
            }
        });
    }

    // Accessor untuk thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    // Scope untuk berita yang dipublikasi
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope untuk berita draft
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }
}
