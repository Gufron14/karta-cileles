<?php

namespace App\Livewire\Admin\Pakaian;

use App\Models\PenyaluranPakaian as ModelsPenyaluranPakaian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Penyaluran Pakaian')]
#[Layout('components.layouts.admin-layout')]
class PenyaluranPakaian extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

    // Properties untuk form
    public $p_laki = '';
    public $p_perempuan = '';
    public $p_anak = '';
    public $tanggal = '';
    public $status = 'pending';

    // Properties untuk edit
    public $editingId = null;
    public $isEditing = false;

    // Property untuk detail
    public $detailData = null;

        protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'p_laki' => 'required|integer|min:0',
        'p_perempuan' => 'required|integer|min:0',
        'p_anak' => 'required|integer|min:0',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,disalurkan'
    ];

    protected $messages = [
        'p_laki.required' => 'Jumlah pakaian laki-laki harus diisi',
        'p_laki.min' => 'Jumlah pakaian laki-laki minimal 0',
        'p_perempuan.required' => 'Jumlah pakaian perempuan harus diisi',
        'p_perempuan.min' => 'Jumlah pakaian perempuan minimal 0',
        'p_anak.required' => 'Jumlah pakaian anak harus diisi',
        'p_anak.min' => 'Jumlah pakaian anak minimal 0',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid'
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->tahunFilter = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->bulanFilter = '';
        $this->tahunFilter = date('Y');
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['p_laki', 'p_perempuan', 'p_anak', 'tanggal', 'status', 'editingId', 'isEditing']);
        $this->tanggal = date('Y-m-d');
        $this->status = 'pending';
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        // Validasi minimal salah satu harus diisi
        if ($this->p_laki == 0 && $this->p_perempuan == 0 && $this->p_anak == 0) {
            $this->addError('p_laki', 'Minimal salah satu kategori pakaian harus diisi');
            return;
        }

        ModelsPenyaluranPakaian::create([
            'p_laki' => $this->p_laki,
            'p_perempuan' => $this->p_perempuan,
            'p_anak' => $this->p_anak,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'tambahModal');
        session()->flash('success', 'Data penyaluran pakaian berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $penyaluran = ModelsPenyaluranPakaian::findOrFail($id);
        
        $this->editingId = $id;
        $this->isEditing = true;
        $this->p_laki = $penyaluran->p_laki;
        $this->p_perempuan = $penyaluran->p_perempuan;
        $this->p_anak = $penyaluran->p_anak;
        $this->tanggal = $penyaluran->tanggal;
        $this->status = $penyaluran->status;

        $this->dispatch('open-modal', 'editModal');
    }

    public function update()
    {
        $this->validate();

        // Validasi minimal salah satu harus diisi
        if ($this->p_laki == 0 && $this->p_perempuan == 0 && $this->p_anak == 0) {
            $this->addError('p_laki', 'Minimal salah satu kategori pakaian harus diisi');
            return;
        }

        $penyaluran = ModelsPenyaluranPakaian::findOrFail($this->editingId);
        $penyaluran->update([
            'p_laki' => $this->p_laki,
            'p_perempuan' => $this->p_perempuan,
            'p_anak' => $this->p_anak,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'editModal');
        session()->flash('success', 'Data penyaluran pakaian berhasil diperbarui!');
    }

    public function detail($id)
    {
        $this->detailData = ModelsPenyaluranPakaian::findOrFail($id);
        $this->dispatch('open-modal', 'detailModal');
    }

    public function updateStatus($id)
    {
        $penyaluran = ModelsPenyaluranPakaian::findOrFail($id);
        $newStatus = $penyaluran->status == 'pending' ? 'disalurkan' : 'pending';
        $penyaluran->update(['status' => $newStatus]);
        
        session()->flash('success', 'Status penyaluran berhasil diperbarui!');
    }

    public function delete($id)
    {
        ModelsPenyaluranPakaian::findOrFail($id)->delete();
        session()->flash('success', 'Data penyaluran pakaian berhasil dihapus!');
    }

public function render()
{
    $query = ModelsPenyaluranPakaian::query();

    // Filter berdasarkan status
    if ($this->statusFilter) {
        $query->where('status', $this->statusFilter);
    }

    // Filter berdasarkan bulan
    if ($this->bulanFilter) {
        $query->whereMonth('tanggal', $this->bulanFilter);
    }

    // Filter berdasarkan tahun
    if ($this->tahunFilter) {
        $query->whereYear('tanggal', $this->tahunFilter);
    }

    $penyalurans = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('livewire.admin.pakaian.penyaluran-pakaian', compact('penyalurans'));
}

}
