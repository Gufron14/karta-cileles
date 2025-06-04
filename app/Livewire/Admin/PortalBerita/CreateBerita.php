<?php

namespace App\Livewire\Admin\PortalBerita;

use App\Models\Berita;
use App\Models\Bencana;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Title('Tambah Berita')]
#[Layout('components.layouts.admin-layout')]
class CreateBerita extends Component
{
    use WithFileUploads;

    public $bencana_id = '';
    public $judul = '';
    public $isi = '';
    public $thumbnail;
    public $is_published = false;

    protected $rules = [
        'bencana_id' => 'required|exists:bencanas,id',
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'is_published' => 'boolean'
    ];

    protected $messages = [
        'bencana_id.required' => 'Jenis bencana harus dipilih',
        'bencana_id.exists' => 'Jenis bencana tidak valid',
        'judul.required' => 'Judul berita harus diisi',
        'judul.max' => 'Judul berita maksimal 255 karakter',
        'isi.required' => 'Isi berita harus diisi',
        'thumbnail.required' => 'Thumbnail berita harus diupload',
        'thumbnail.image' => 'File harus berupa gambar',
        'thumbnail.mimes' => 'Format gambar harus jpeg, png, atau jpg',
        'thumbnail.max' => 'Ukuran gambar maksimal 2MB'
    ];

    public function updatedIsi($value)
    {
        $this->isi = $value;
    }

    public function save()
    {
        $this->validate();

        try {
            // Upload thumbnail
            $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');

            // Generate slug
            $slug = Str::slug($this->judul);
            $originalSlug = $slug;
            $counter = 1;

            // Pastikan slug unik
            while (Berita::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Simpan berita
            Berita::create([
                'bencana_id' => $this->bencana_id,
                'judul' => $this->judul,
                'isi' => $this->isi,
                'slug' => $slug,
                'thumbnail' => $thumbnailPath,
                'is_published' => $this->is_published
            ]);

            session()->flash('message', 'Berita berhasil ditambahkan!');
            return redirect()->route('kelola-berita');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $bencanas = Bencana::all();
        
        return view('livewire.admin.portal-berita.create-berita', [
            'bencanas' => $bencanas
        ]);
    }
}
