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

    // Form properties
    public $jumlah = 0;
    public $alamat = '';
    public $jml_kk = 0;
    public $nama_kk = '';

    public $tanggal;
    public $status = 'pending';

    // Filter properties
    public $statusFilter = '';
    public $bulanFilter = '';
    public $tahunFilter = '';

    // Other properties
    public $editId = null;
    public $detailData = null;

    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'jumlah' => 'required|integer|min:1',
        'alamat' => 'required|string|max:255',
        'jml_kk' => 'required|integer|min:1',
        'nama_kk' => 'required|string',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,disalurkan',
    ];

    protected $messages = [
        'jumlah.required' => 'Jumlah makanan harus diisi',
        'jumlah.integer' => 'Jumlah makanan harus berupa angka',
        'jumlah.min' => 'Jumlah makanan minimal 1',
        'alamat.required' => 'Alamat harus diisi',
        'alamat.max' => 'Alamat maksimal 255 karakter',
        'jml_kk.required' => 'Jumlah KK harus diisi',
        'jml_kk.integer' => 'Jumlah KK harus berupa angka',
        'jml_kk.min' => 'Jumlah KK minimal 1',
        'tanggal.required' => 'Tanggal harus diisi',
        'tanggal.date' => 'Format tanggal tidak valid',
        'status.required' => 'Status harus dipilih',
        'status.in' => 'Status harus pending atau disalurkan',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

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

    public function resetForm()
    {
        $this->reset(['jumlah', 'alamat', 'jml_kk', 'nama_kk', 'status', 'editId']);
        $this->tanggal = date('Y-m-d');
        $this->resetErrorBag();
    }

    public function resetFilters()
    {
        $this->reset(['statusFilter', 'bulanFilter', 'tahunFilter']);
        $this->resetPage();
    }

    public function store()
    {
        $this->validate();

        PenyaluranMakananModel::create([
            'jumlah' => $this->jumlah,
            'alamat' => $this->alamat,
            'jml_kk' => $this->jml_kk,
            'nama_kk' => $this->nama_kk ? json_encode(array_map('trim', explode(',', $this->nama_kk))) : null,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'tambahModal');
        session()->flash('success', 'Data penyaluran makanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $penyaluran = PenyaluranMakananModel::findOrFail($id);
        
        $this->editId = $id;
        $this->jumlah = $penyaluran->jumlah;
        $this->alamat = $penyaluran->alamat;
        $this->jml_kk = $penyaluran->jml_kk;
        $this->nama_kk = $penyaluran->nama_kk ? implode(', ', json_decode($penyaluran->nama_kk)) : '';
        $this->tanggal = $penyaluran->tanggal;
        $this->status = $penyaluran->status;

        $this->dispatch('open-modal', 'editModal');
    }

    public function update()
    {
        $this->validate();

        $penyaluran = PenyaluranMakananModel::findOrFail($this->editId);
        $penyaluran->update([
            'jumlah' => $this->jumlah,
            'alamat' => $this->alamat,
            'jml_kk' => $this->jml_kk,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'editModal');
        session()->flash('success', 'Data penyaluran makanan berhasil diperbarui!');
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
