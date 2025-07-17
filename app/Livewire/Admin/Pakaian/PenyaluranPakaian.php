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
    public $pakaian_data = [];
    public $tanggal = '';
    public $status = 'pending';

    // Properties untuk edit
    public $editingId = null;
    public $isEditing = false;

    // Property untuk detail
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'pakaian_data' => 'required|array|min:1',
        'pakaian_data.*.jenis' => 'required|in:laki-laki,perempuan,anak',
        'pakaian_data.*.jumlah' => 'required|integer|min:1',
        'pakaian_data.*.ukuran' => 'required|string|max:10',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,disalurkan',
    ];

    protected $messages = [
        'pakaian_data.required' => 'Data pakaian harus diisi',
        'pakaian_data.*.jenis.required' => 'Jenis pakaian harus dipilih',
        'pakaian_data.*.jumlah.required' => 'Jumlah pakaian harus diisi',
        'pakaian_data.*.jumlah.min' => 'Jumlah pakaian minimal 1',
        'pakaian_data.*.ukuran.required' => 'Ukuran pakaian harus diisi',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->tahunFilter = date('Y');
        $this->resetPakaianData();
    }

    public function resetPakaianData()
    {
        $this->pakaian_data = [
            [
                'jenis' => '',
                'jumlah' => '',
                'ukuran' => ''
            ]
        ];
    }

    public function addPakaianData()
    {
        $this->pakaian_data[] = [
            'jenis' => '',
            'jumlah' => '',
            'ukuran' => ''
        ];
    }

    public function removePakaianData($index)
    {
        if (count($this->pakaian_data) > 1) {
            unset($this->pakaian_data[$index]);
            $this->pakaian_data = array_values($this->pakaian_data);
        }
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
        $this->reset(['tanggal', 'status', 'editingId', 'isEditing']);
        $this->tanggal = date('Y-m-d');
        $this->status = 'pending';
        $this->resetPakaianData();
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        // Filter data pakaian yang kosong
        $pakaianData = array_filter($this->pakaian_data, function($item) {
            return !empty($item['jenis']) && !empty($item['jumlah']) && !empty($item['ukuran']);
        });

        if (empty($pakaianData)) {
            $this->addError('pakaian_data', 'Minimal harus ada satu data pakaian yang lengkap');
            return;
        }

        ModelsPenyaluranPakaian::create([
            'pakaian_data' => array_values($pakaianData),
            'tanggal' => $this->tanggal,
            'status' => $this->status,
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
        $this->pakaian_data = $penyaluran->pakaian_data;
        $this->tanggal = $penyaluran->tanggal;
        $this->status = $penyaluran->status;

        $this->dispatch('open-modal', 'editModal');
    }

    public function update()
    {
        $this->validate();

        // Filter data pakaian yang kosong
        $pakaianData = array_filter($this->pakaian_data, function($item) {
            return !empty($item['jenis']) && !empty($item['jumlah']) && !empty($item['ukuran']);
        });

        if (empty($pakaianData)) {
            $this->addError('pakaian_data', 'Minimal harus ada satu data pakaian yang lengkap');
            return;
        }

        $penyaluran = ModelsPenyaluranPakaian::findOrFail($this->editingId);
        $penyaluran->update([
            'pakaian_data' => array_values($pakaianData),
            'tanggal' => $this->tanggal,
            'status' => $this->status,
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
