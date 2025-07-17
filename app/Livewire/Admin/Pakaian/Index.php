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
    public $nama_donatur = '';
    public $tanggal = '';
    public $status = 'pending';
    public $pakaian_data = [];

    // Properties untuk edit
    public $editingId = null;
    public $isEditing = false;

    // Property untuk detail
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nama_donatur' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,terverifikasi',
        'pakaian_data' => 'required|array|min:1',
        'pakaian_data.*.jenis' => 'required|string',
        'pakaian_data.*.jumlah' => 'required|integer|min:1',
        'pakaian_data.*.ukuran' => 'required|string',
    ];

    protected $messages = [
        'nama_donatur.required' => 'Nama donatur harus diisi',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'pakaian_data.required' => 'Data pakaian harus diisi',
        'pakaian_data.min' => 'Minimal harus ada 1 data pakaian',
        'pakaian_data.*.jenis.required' => 'Jenis pakaian harus dipilih',
        'pakaian_data.*.jumlah.required' => 'Jumlah pakaian harus diisi',
        'pakaian_data.*.jumlah.min' => 'Jumlah pakaian minimal 1',
        'pakaian_data.*.ukuran.required' => 'Ukuran pakaian harus dipilih',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->tahunFilter = date('Y');
        $this->pakaian_data = [
            ['jenis' => '', 'jumlah' => '', 'ukuran' => '']
        ];
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
        $this->reset(['nama_donatur', 'tanggal', 'status', 'pakaian_data', 'editingId', 'isEditing']);
        $this->tanggal = date('Y-m-d');
        $this->status = 'pending';
        $this->pakaian_data = [
            ['jenis' => '', 'jumlah' => '', 'ukuran' => '']
        ];
        $this->resetValidation();
    }

    public function addPakaianData()
    {
        $this->pakaian_data[] = ['jenis' => '', 'jumlah' => '', 'ukuran' => ''];
    }

    public function removePakaianData($index)
    {
        if (count($this->pakaian_data) > 1) {
            unset($this->pakaian_data[$index]);
            $this->pakaian_data = array_values($this->pakaian_data);
        }
    }

    public function store()
    {
        $this->validate();

        // Filter data pakaian yang kosong
        $pakaianData = array_filter($this->pakaian_data, function($item) {
            return !empty($item['jenis']) && !empty($item['jumlah']) && !empty($item['ukuran']);
        });

        Pakaian::create([
            'pakaian_data' => array_values($pakaianData),
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'pakaianModal');
        session()->flash('success', 'Data pakaian berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pakaian = Pakaian::findOrFail($id);
        
        $this->editingId = $id;
        $this->isEditing = true;
        $this->nama_donatur = $pakaian->nama_donatur;
        $this->tanggal = $pakaian->tanggal->format('Y-m-d');
        $this->status = $pakaian->status;
        $this->pakaian_data = $pakaian->pakaian_data ?: [['jenis' => '', 'jumlah' => '', 'ukuran' => '']];

        $this->dispatch('open-modal', 'pakaianModal');
    }

    public function update()
    {
        $this->validate();

        // Filter data pakaian yang kosong
        $pakaianData = array_filter($this->pakaian_data, function($item) {
            return !empty($item['jenis']) && !empty($item['jumlah']) && !empty($item['ukuran']);
        });

        $pakaian = Pakaian::findOrFail($this->editingId);
        $pakaian->update([
            'pakaian_data' => array_values($pakaianData),
            'nama_donatur' => $this->nama_donatur,
            'tanggal' => $this->tanggal,
            'status' => $this->status
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'pakaianModal');
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
                $q->where('nama_donatur', 'like', '%' . $this->search . '%');
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
