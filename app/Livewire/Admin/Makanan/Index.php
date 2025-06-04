<?php

namespace App\Livewire\Admin\Makanan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use App\Models\Makanan;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Title('Data Makanan Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]
class Index extends Component
{
    use WithPagination;

    // Form properties
    public $jenis_makanan = '';
    public $jumlah_makanan = '';
    public $nama_donatur = '';
    public $tanggal;
    public $status = 'pending';

    // Filter properties
    public $search = '';
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

    // Other properties
    public $editId = null;
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'jenis_makanan' => 'required|string|max:255',
        'jumlah_makanan' => 'nullable|integer|min:1',
        'nama_donatur' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,terverifikasi',
    ];

    protected $messages = [
        'jenis_makanan.required' => 'Jenis makanan harus diisi',
        'jenis_makanan.max' => 'Jenis makanan maksimal 255 karakter',
        'jumlah_makanan.integer' => 'Jumlah makanan harus berupa angka',
        'jumlah_makanan.min' => 'Jumlah makanan minimal 1',
        'nama_donatur.required' => 'Nama donatur harus diisi',
        'nama_donatur.max' => 'Nama donatur maksimal 255 karakter',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'status.required' => 'Status harus dipilih',
        'status.in' => 'Status harus pending atau terverifikasi',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        $query = Makanan::query();

        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_donatur', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_makanan', 'like', '%' . $this->search . '%');
            });
        }

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

        $makanans = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('livewire.admin.makanan.index', [
            'makanans' => $makanans
        ]);
    }

    public function resetForm()
    {
        $this->reset(['jenis_makanan', 'jumlah_makanan', 'nama_donatur', 'status', 'editId']);
        $this->tanggal = date('Y-m-d');
        $this->resetErrorBag();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'bulanFilter', 'tahunFilter']);
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();

        Makanan::create([
            'jenis_makanan' => $this->jenis_makanan,
            'jumlah_makanan' => $this->jumlah_makanan ?: null,
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'tambahModal');
        session()->flash('success', 'Data makanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $makanan = Makanan::findOrFail($id);
        
        $this->editId = $id;
        $this->jenis_makanan = $makanan->jenis_makanan;
        $this->jumlah_makanan = $makanan->jumlah_makanan;
        $this->nama_donatur = $makanan->nama_donatur;
        $this->tanggal = $makanan->tanggal;
        $this->status = $makanan->status;

        $this->dispatch('open-modal', 'editModal');
    }

    public function update()
    {
        $this->validate();

        $makanan = Makanan::findOrFail($this->editId);
        $makanan->update([
            'jenis_makanan' => $this->jenis_makanan,
            'jumlah_makanan' => $this->jumlah_makanan ?: null,
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'editModal');
        session()->flash('success', 'Data makanan berhasil diperbarui!');
    }

    public function detail($id)
    {
        $this->detailData = Makanan::findOrFail($id);
        $this->dispatch('open-modal', 'detailModal');
    }

    public function delete($id)
    {
        Makanan::findOrFail($id)->delete();
        session()->flash('success', 'Data makanan berhasil dihapus!');
    }

    public function verifikasi($id)
    {
        $makanan = Makanan::findOrFail($id);
        $makanan->update(['status' => 'terverifikasi']);
        
        session()->flash('success', 'Data makanan berhasil diverifikasi!');
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
}
