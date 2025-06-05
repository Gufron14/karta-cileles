<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Baca Berita')]
class ViewBerita extends Component
{
    public $slug;
    public $berita;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->berita = Berita::with('bencana')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();
    }

    // #[Title]
    public function title()
    {
        return $this->berita->judul . ' - Karang Taruna Cileles';
    }

    public function render()
    {
        $relatedNews = Berita::with('bencana')
            ->published()
            ->where('id', '!=', $this->berita->id)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.berita.view-berita', compact('relatedNews'));
    }
}
