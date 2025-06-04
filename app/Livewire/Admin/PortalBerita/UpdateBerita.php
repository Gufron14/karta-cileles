<?php

namespace App\Livewire\Admin\PortalBerita;

use App\Models\Berita;
use App\Models\Bencana;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

#[Title('Edit Berita')]
#[Layout('components.layouts.admin-layout')]
class UpdateBerita extends Component
{
    use WithFileUploads;

    public $beritaId;
    public $berita;
    public $bencana_id;
    public $judul;
    public $isi;
    public $thumbnail;
    public $existing_thumbnail;
    public $is_published;

    protected $rules = [
        'bencana_id' => 'required|exists:bencanas,id',
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'is_published' => 'boolean'
    ];

    protected $messages = [
        'bencana_id.required' => 'Jenis bencana harus dipilih',
        'bencana_id.exists' => 'Jenis bencana tidak valid',
        'judul.required' => 'Judul berita harus diisi',
        'judul.max' => 'Judul berita maksimal 255 karakter',
        'isi.required' => 'Isi berita harus diisi',
        'thumbnail.image' => 'File harus berupa gambar',
        'thumbnail.mimes' => 'Format gambar harus jpeg, png, atau jpg',
        'thumbnail.max' => 'Ukuran gambar maksimal 2MB'
    ];

    public function mount($id)
    {
        $this->beritaId = $id;
        $this->berita = Berita::findOrFail($id);
        
        $this->bencana_id = $this->berita->bencana_id;
        $this->judul = $this->berita->judul;
        $this->isi = $this->berita->isi;
        $this->existing_thumbnail = $this->berita->thumbnail;
        $this->is_published = $this->berita->is_published;
    }

    public function updatedIsi($value)
    {
        $this->isi = $value;
    }

    public function update()
    {
        $this->validate();

        try {
            $updateData = [
                'bencana_id' => $this->bencana_id,
                'judul' => $this->judul,
                'isi' => $this->isi,
                'is_published' => $this->is_published
            ];

            // Jika judul berubah, update slug
            if ($this->berita->judul !== $this->judul) {
                $slug = Str::slug($this->judul);
                $originalSlug = $slug;
                $counter = 1;

                // Pastikan slug unik (kecuali untuk berita yang sedang diedit)
                while (Berita::where('slug', $slug)->where('id', '!=', $this->beritaId)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                
                $updateData['slug'] = $slug;
            }

            // Jika ada thumbnail baru
            if ($this->thumbnail) {
                // Hapus thumbnail lama
                if ($this->existing_thumbnail && Storage::disk('public')->exists($this->existing_thumbnail)) {
                    Storage::disk('public')->delete($this->existing_thumbnail);
                }
                
                // Upload thumbnail baru
                $updateData['thumbnail'] = $this->thumbnail->store('thumbnails', 'public');
            }

            $this->berita->update($updateData);

            session()->flash('message', 'Berita berhasil diperbarui!');
            return redirect()->route('kelola-berita');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $bencanas = Bencana::all();
        
        return view('livewire.admin.portal-berita.update-berita', [
            'bencanas' => $bencanas
        ]);
    }
}
