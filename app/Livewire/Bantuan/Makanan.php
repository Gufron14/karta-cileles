<?php

namespace App\Livewire\Bantuan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Makanan as MakananModel;
use App\Models\PenyaluranMakanan;

#[Title('Data Makanan & Penyaluran')]
class Makanan extends Component
{
    use WithPagination;

    // Filter properti untuk makanan
    public $search = '';
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

    // Filter properti untuk penyaluran makanan
    public $statusPenyaluranFilter = '';
    public $bulanPenyaluranFilter = '';
    public $tahunPenyaluranFilter = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingBulanFilter() { $this->resetPage(); }
    public function updatingTahunFilter() { $this->resetPage(); }
    public function updatingStatusPenyaluranFilter() { $this->resetPage(); }
    public function updatingBulanPenyaluranFilter() { $this->resetPage(); }
    public function updatingTahunPenyaluranFilter() { $this->resetPage(); }

    public function resetFiltersMakanan()
    {
        $this->reset(['search', 'statusFilter', 'bulanFilter', 'tahunFilter']);
        $this->resetPage();
    }

    public function resetFiltersPenyaluran()
    {
        $this->reset(['statusPenyaluranFilter', 'bulanPenyaluranFilter', 'tahunPenyaluranFilter']);
        $this->resetPage();
    }

    public function render()
    {
        // Query makanan
        $queryMakanan = MakananModel::query();
        if ($this->search) {
            $queryMakanan->where(function($q) {
                $q->where('nama_donatur', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_makanan', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->statusFilter) {
            $queryMakanan->where('status', $this->statusFilter);
        }
        if ($this->bulanFilter) {
            $queryMakanan->whereMonth('tanggal', $this->bulanFilter);
        }
        if ($this->tahunFilter) {
            $queryMakanan->whereYear('tanggal', $this->tahunFilter);
        }
        $makanans = $queryMakanan->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'makananPage');

        // Query penyaluran makanan
        $queryPenyaluran = PenyaluranMakanan::query();
        if ($this->statusPenyaluranFilter) {
            $queryPenyaluran->where('status', $this->statusPenyaluranFilter);
        }
        if ($this->bulanPenyaluranFilter) {
            $queryPenyaluran->whereMonth('tanggal', $this->bulanPenyaluranFilter);
        }
        if ($this->tahunPenyaluranFilter) {
            $queryPenyaluran->whereYear('tanggal', $this->tahunPenyaluranFilter);
        }
        $penyalurans = $queryPenyaluran->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'penyaluranPage');

        return view('livewire.bantuan.makanan', [
            'makanans' => $makanans,
            'penyalurans' => $penyalurans,
        ]);
    }
}