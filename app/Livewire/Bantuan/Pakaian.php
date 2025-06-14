<?php

namespace App\Livewire\Bantuan;

use App\Models\Pakaian as PakaianModel;
use App\Models\PenyaluranPakaian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Data Pakaian')]
class Pakaian extends Component
{
    use WithPagination;

    public $searchPakaian = '';
    public $statusPakaianFilter = '';
    public $bulanPakaianFilter = '';
    public $tahunPakaianFilter = '';

    public $filterStatusPenyaluran = '';
    public $filterBulanPenyaluran = '';
    public $filterTahunPenyaluran = '';

    // Properties untuk form
    public $jenis_pakaian = '';
    public $jumlah_pakaian = '';
    public $nama_donatur = '';
    public $tanggal = '';
    public $status = 'pending';

    // Properties untuk edit
    public $editingId = null;
    public $isEditing = false;

    // Property untuk detail
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->tahunPakaianFilter = date('Y');
        $this->filterTahunPenyaluran = date('Y');
    }

    public function resetFiltersPakaian()
    {
        $this->searchPakaian = '';
        $this->statusPakaianFilter = '';
        $this->bulanPakaianFilter = '';
        $this->tahunPakaianFilter = date('Y');
        $this->resetPage();
    }

    public function resetFiltersPenyaluran()
    {
        $this->filterBulanPenyaluran = '';
        $this->filterStatusPenyaluran = '';
        $this->filterTahunPenyaluran = date('Y');
        $this->resetPage();
    }
    public function updatingSearchPakaian()
    {
        $this->resetPage();
    }
    public function updatingStatusPakaianFilter()
    {
        $this->resetPage();
    }
    public function updatingBulanPakaianFilter()
    {
        $this->resetPage();
    }
    public function updatingTahunPakaianFilter()
    {
        $this->resetPage();
    }
    public function updatingFilterStatusPenyaluran()
    {
        $this->resetPage();
    }
    public function updatingFilterBulanPenyaluran()
    {
        $this->resetPage();
    }
    public function updatingFilterTahunPenyaluran()
    {
        $this->resetPage();
    }

    public function render()
    {
        $queryPakaian = PakaianModel::query();

        // Filter berdasarkan pencarian
        if ($this->searchPakaian) {
            $queryPakaian->where(function ($q) {
                $q->where('nama_donatur', 'like', '%' . $this->searchPakaian . '%')->orWhere('jenis_pakaian', 'like', '%' . $this->searchPakaian . '%');
            });
        }

        // Filter berdasarkan status
        if ($this->statusPakaianFilter) {
            $queryPakaian->where('status', $this->statusPakaianFilter);
        }

        // Filter berdasarkan bulan
        if ($this->bulanPakaianFilter) {
            $queryPakaian->whereMonth('tanggal', $this->bulanPakaianFilter);
        }

        // Filter berdasarkan tahun
        if ($this->tahunPakaianFilter) {
            $queryPakaian->whereYear('tanggal', $this->tahunPakaianFilter);
        }

        $pakaians = $queryPakaian->orderBy('created_at', 'desc')->paginate(10);

        // Query untuk data penyaluran
        $penyaluransQuery = PenyaluranPakaian::query();

        if ($this->filterBulanPenyaluran) {
            $penyaluransQuery->whereMonth('tanggal', $this->filterBulanPenyaluran);
        }

        if ($this->filterTahunPenyaluran) {
            $penyaluransQuery->whereYear('tanggal', $this->filterTahunPenyaluran);
        }

        if ($this->filterStatusPenyaluran) {
            $penyaluransQuery->where('status', $this->filterStatusPenyaluran);
        }

        $penyalurans = $penyaluransQuery->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.bantuan.pakaian', [
            'pakaians' => $pakaians,
            'penyalurans' => $penyalurans,
        ]);
    }
}
