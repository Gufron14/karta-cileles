<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DokumentasiBencana;

#[Title('Karang Taruna Kecamatan Cileles')]
class Home extends Component
{
    public $latestBerita;
    public $otherBerita;
    public $dokumentasiFoto;

    public function mount()
    {
        // Ambil 5 berita terakhir yang dipublikasi
        $beritas = Berita::with('bencana')
            ->published()
            ->latest()
            ->take(5)
            ->get();

        // Pisahkan berita pertama sebagai highlight
        $this->latestBerita = $beritas->first();
        $this->otherBerita = $beritas->skip(1);

        // Ambil dokumentasi foto bencana (6 foto untuk gallery)
        $this->dokumentasiFoto = DokumentasiBencana::with('bencana')
            ->where('jenis_media', 'foto')
            ->whereNotNull('file_path')
            ->latest()
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.home');
    }
}
