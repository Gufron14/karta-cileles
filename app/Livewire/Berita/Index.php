<?php

namespace App\Livewire\Berita;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Berita Karang Taruna Cileles')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.berita.index');
    }
}
