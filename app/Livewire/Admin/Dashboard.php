<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Dashboard Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
