<?php

namespace App\Livewire\PascaBencana;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\DokumentasiBencana;

#[Title('Dokumentasi Bencana')]

class Bencana extends Component
{
    public function render()
    {
        // Ambil dokumentasi beserta relasi bencana
        $dokumentasi = DokumentasiBencana::with('bencana')->latest()->get();

        return view('livewire.pasca-bencana.bencana', [
            'dokumentasi' => $dokumentasi,
        ]);
    }
}