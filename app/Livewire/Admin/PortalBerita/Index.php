<?php

namespace App\Livewire\Admin\PortalBerita;

use App\Models\Berita;
use App\Models\Bencana;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Kelola Portal Berita')]
#[Layout('components.layouts.admin-layout')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $bencana_filter = '';
    public $status_filter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingBencanaFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($beritaId)
    {
        $berita = Berita::find($beritaId);
        if ($berita) {
            $berita->update(['is_published' => !$berita->is_published]);
            session()->flash('message', 'Status berita berhasil diubah!');
        }
    }

    public function deleteBerita($beritaId)
    {
        $berita = Berita::find($beritaId);
        if ($berita) {
            // Hapus file thumbnail jika ada
            if ($berita->thumbnail && file_exists(storage_path('app/public/' . $berita->thumbnail))) {
                unlink(storage_path('app/public/' . $berita->thumbnail));
            }
            
            $berita->delete();
            session()->flash('message', 'Berita berhasil dihapus!');
        }
    }

    public function render()
    {
        $beritas = Berita::with('bencana')
            ->when($this->search, function ($query) {
                $query->where('judul', 'like', '%' . $this->search . '%');
            })
            ->when($this->bencana_filter, function ($query) {
                $query->where('bencana_id', $this->bencana_filter);
            })
            ->when($this->status_filter !== '', function ($query) {
                $query->where('is_published', $this->status_filter);
            })
            ->latest()
            ->paginate(10);

        $bencanas = Bencana::all();

        return view('livewire.admin.portal-berita.index', [
            'beritas' => $beritas,
            'bencanas' => $bencanas
        ]);
    }
}
