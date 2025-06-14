<?php

namespace App\Livewire\Admin\Pakaian;

use App\Models\Pakaian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Data Pakaian Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

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


    protected $rules = [
        'jenis_pakaian' => 'required|string|max:255',
        'jumlah_pakaian' => 'required|integer|min:1',
        'nama_donatur' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,terverifikasi'
    ];

    protected $messages = [
        'jenis_pakaian.required' => 'Jenis pakaian harus diisi',
        'jumlah_pakaian.required' => 'Jumlah pakaian harus diisi',
        'jumlah_pakaian.min' => 'Jumlah pakaian minimal 1',
        'nama_donatur.required' => 'Nama donatur harus diisi',
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
        $this->reset(['jenis_pakaian', 'jumlah_pakaian', 'nama_donatur', 'tanggal', 'status', 'editingId', 'isEditing']);
        $this->tanggal = date('Y-m-d');
        $this->status = 'pending';
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        Pakaian::create([
            'jenis_pakaian' => $this->jenis_pakaian,
            'jumlah_pakaian' => $this->jumlah_pakaian,
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'tambahModal');
        session()->flash('success', 'Data pakaian berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pakaian = Pakaian::findOrFail($id);
        
        $this->editingId = $id;
        $this->isEditing = true;
        $this->jenis_pakaian = $pakaian->jenis_pakaian;
        $this->jumlah_pakaian = $pakaian->jumlah_pakaian;
        $this->nama_donatur = $pakaian->nama_donatur;
        $this->tanggal = $pakaian->tanggal;
        $this->status = $pakaian->status;

        $this->dispatch('open-modal', 'editModal');
    }

    public function update()
    {
        $this->validate();

        $pakaian = Pakaian::findOrFail($this->editingId);
        $pakaian->update([
            'jenis_pakaian' => $this->jenis_pakaian,
            'jumlah_pakaian' => $this->jumlah_pakaian,
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'editModal');
        session()->flash('success', 'Data pakaian berhasil diperbarui!');
    }

    public function detail($id)
    {
        $this->detailData = Pakaian::findOrFail($id);
        $this->dispatch('open-modal', 'detailModal');
    }

    public function verifikasi($id)
    {
        $pakaian = Pakaian::findOrFail($id);
        $pakaian->update(['status' => 'terverifikasi']);
        
        session()->flash('success', 'Data pakaian berhasil diverifikasi!');
    }

    public function delete($id)
    {
        Pakaian::findOrFail($id)->delete();
        session()->flash('success', 'Data pakaian berhasil dihapus!');
    }

    public function render()
    {
        $query = Pakaian::query();

        // Filter berdasarkan pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_donatur', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_pakaian', 'like', '%' . $this->search . '%');
            });
        }

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

        $pakaians = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.pakaian.index', [
            'pakaians' => $pakaians
        ]);
    }
}
