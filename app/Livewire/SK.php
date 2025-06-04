<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Syarat & Ketentuan')]
class SK extends Component
{
    public function render()
    {
        return view('livewire.s-k');
    }
}
