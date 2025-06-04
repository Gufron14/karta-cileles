<?php

namespace App\Livewire\Berita;

use App\Models\Berita;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Berita Karang Taruna Cileles')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 6;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritas = Berita::with('bencana')
            ->published()
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                      ->orWhere('isi', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.berita.index', compact('beritas'));
    }
}
