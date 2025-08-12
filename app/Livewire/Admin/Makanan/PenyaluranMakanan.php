<?php

namespace App\Livewire\Admin\Makanan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\PenyaluranMakanan as PenyaluranMakananModel;
use Carbon\Carbon;

#[Title('Penyaluran Makanan')]
#[Layout('components.layouts.admin-layout')]
class PenyaluranMakanan extends Component
{
    use WithPagination;

    // Filter properties
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

    // Other properties
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $query = PenyaluranMakananModel::query();

        // Apply filters
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->bulanFilter) {
            $query->whereMonth('tanggal', $this->bulanFilter);
        }

        if ($this->tahunFilter) {
            $query->whereYear('tanggal', $this->tahunFilter);
        }

        $penyalurans = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('livewire.admin.makanan.penyaluran-makanan', [
            'penyalurans' => $penyalurans
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['statusFilter', 'bulanFilter', 'tahunFilter']);
        $this->resetPage();
    }

    public function create()
    {
        return redirect()->route('admin.penyaluran-makanan.create');
    }

    public function edit($id)
    {
        return redirect()->route('admin.penyaluran-makanan.edit', $id);
    }

    public function detail($id)
    {
        $this->detailData = PenyaluranMakananModel::findOrFail($id);
        $this->dispatch('open-modal', 'detailModal');
    }

    public function delete($id)
    {
        PenyaluranMakananModel::findOrFail($id)->delete();
        session()->flash('success', 'Data penyaluran makanan berhasil dihapus!');
    }

    public function updateStatus($id)
    {
        $penyaluran = PenyaluranMakananModel::findOrFail($id);
        $newStatus = $penyaluran->status === 'pending' ? 'disalurkan' : 'pending';
        
        $penyaluran->update(['status' => $newStatus]);
        
        $statusText = $newStatus === 'disalurkan' ? 'disalurkan' : 'pending';
        session()->flash('success', "Status berhasil diubah menjadi {$statusText}!");
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingBulanFilter()
    {
        $this->resetPage();
    }

    public function updatingTahunFilter()
    {
        $this->resetPage();
    }
}
