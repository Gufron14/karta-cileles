<?php

namespace App\Livewire\Admin;

use App\Models\Donasi as DonasiModel;
use App\Models\PenyaluranDonasi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Data Donasi Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]
class Donasi extends Component
{
    use WithPagination, WithFileUploads;

    // Filter properties
    public $searchDonasi = '';
    public $filterBulanDonasi = '';
    public $filterTahunDonasi = '';
    public $filterStatusDonasi = '';
    public $nama_kk = '';
    public $nomor_kk = '';
    
    public $searchPenyaluran = '';
    public $filterBulanPenyaluran = '';
    public $filterTahunPenyaluran = '';
    public $filterStatusPenyaluran = '';

    // Modal Donasi properties
    public $showModalDonasi = false;
    public $donasiId = null;
    public $nama_donatur = '';
    public $email = '';
    public $no_hp = '';
    public $nominal = '';
    public $bukti_transfer;
    public $catatan = '';
    public $status_donasi = 'pending';

    // Modal Penyaluran properties
    public $showModalPenyaluran = false;
    
    public function createPenyaluranPage()
    {
        return redirect()->route('admin.penyaluran-donasi.create');
    }
    public $penyaluranId = null;
    public $tanggal = '';
    public $uang_keluar = '';
    public $alamat = '';
    public $jml_kpl_keluarga = '';
    public $keterangan = '';
    public $status_penyaluran = 'pending';

    public $showModalDetail = false;
    public $detailDonasi = null;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->filterTahunDonasi = date('Y');
        $this->filterTahunPenyaluran = '';
        $this->tanggal = date('Y-m-d');
    }

    // Donasi Methods
    public function openModalDonasi($id = null)
    {
        $this->resetDonasiForm();
        if ($id) {
            $donasi = DonasiModel::find($id);
            $this->donasiId = $donasi->id;
            $this->nama_donatur = $donasi->nama_donatur;
            $this->email = $donasi->email;
            $this->no_hp = $donasi->no_hp;
            $this->nominal = $donasi->nominal;
            $this->catatan = $donasi->catatan;
            $this->status_donasi = $donasi->status;
        }
        $this->showModalDonasi = true;
    }

    public function closeModalDonasi()
    {
        $this->showModalDonasi = false;
        $this->resetDonasiForm();
    }

    public function showDetailDonasi($id)
    {
        $this->detailDonasi = DonasiModel::find($id);
        $this->showModalDetail = true;
    }

    public function closeModalDetail()
    {
        $this->showModalDetail = false;
        $this->detailDonasi = null;
    }

    public function resetDonasiForm()
    {
        $this->donasiId = null;
        $this->nama_donatur = '';
        $this->email = '';
        $this->no_hp = '';
        $this->nominal = '';
        $this->bukti_transfer = null;
        $this->catatan = '';
        $this->status_donasi = 'pending';
        $this->resetErrorBag();
    }

    public function savedonasi()
    {
        $rules = [
            'nama_donatur' => 'required|min:3|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|numeric|digits_between:10,15',
            'nominal' => 'required|numeric|min:1000',
            'catatan' => 'nullable|max:500',
            'status_donasi' => 'required|in:pending,terverifikasi',
        ];
    
        if (!$this->donasiId) {
            $rules['bukti_transfer'] = 'required|image|max:2048';
        } else {
            $rules['bukti_transfer'] = 'nullable|image|max:2048';
        }
    
        $this->validate($rules);
    
        try {
            // Generate kode transaksi
            $tanggal = date('dmY');
            $lastDonasi = DonasiModel::whereDate('created_at', today())->count();
            $nomorUrut = str_pad($lastDonasi + 1, 4, '0', STR_PAD_LEFT);
            $kodeTransaksi = 'DNS' . $tanggal . $nomorUrut;
    
            $data = [
                'kode_transaksi' => $kodeTransaksi,
                'nama_donatur' => $this->nama_donatur,
                'email' => $this->email,
                'no_hp' => $this->no_hp,
                'nominal' => $this->nominal,
                'catatan' => $this->catatan,
                'status' => $this->status_donasi,
            ];
    
            if ($this->bukti_transfer) {
                $data['bukti_transfer'] = $this->bukti_transfer->store('bukti-transfer', 'public');
            }
    
            DonasiModel::create($data);
            session()->flash('success', 'Data donasi berhasil ditambahkan!');
    
            $this->closeModalDonasi();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function verifikasiDonasi($id)
    {
        try {
            $donasi = DonasiModel::find($id);
            $donasi->update(['status' => 'terverifikasi']);
            session()->flash('success', 'Donasi berhasil diverifikasi!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat verifikasi donasi.');
        }
    }

    public function deleteDonasi($id)
    {
        try {
            DonasiModel::find($id)->delete();
            session()->flash('success', 'Data donasi berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    // Penyaluran Methods
    public function openModalPenyaluran($id = null)
    {
        $this->resetPenyaluranForm();
        if ($id) {
            $penyaluran = PenyaluranDonasi::find($id);
            $this->penyaluranId = $penyaluran->id;
            $this->tanggal = $penyaluran->tanggal;
            $this->uang_keluar = $penyaluran->uang_keluar;
            $this->alamat = $penyaluran->alamat;
            $this->jml_kpl_keluarga = $penyaluran->jml_kpl_keluarga;
            $this->nama_kk = $penyaluran->nama_kk;
            $this->keterangan = $penyaluran->keterangan;
            $this->status_penyaluran = $penyaluran->status;
        }
        $this->showModalPenyaluran = true;
    }

    public function closeModalPenyaluran()
    {
        $this->showModalPenyaluran = false;
        $this->resetPenyaluranForm();
    }

    public function resetPenyaluranForm()
    {
        $this->penyaluranId = null;
        $this->tanggal = date('Y-m-d');
        $this->uang_keluar = '';
        $this->alamat = '';
        $this->jml_kpl_keluarga = '';
        $this->nama_kk = '';
        $this->keterangan = '';
        $this->status_penyaluran = 'pending';
        $this->resetErrorBag();
    }

public function savePenyaluran()
{
    $this->validate([
        'tanggal' => 'required|date',
        'uang_keluar' => 'required|numeric|min:1000',
        'alamat' => 'required|min:5|max:255',
        'jml_kpl_keluarga' => 'required|numeric|min:1',
        'nama_kk' => 'required|string',
        'keterangan' => 'nullable|max:500',
        'status_penyaluran' => 'required|in:pending,terverifikasi',
    ]);

    // Hitung total donasi terverifikasi dan total penyaluran terverifikasi
    $totalDonasi = DonasiModel::where('status', 'terverifikasi')->sum('nominal');
    $totalPenyaluran = PenyaluranDonasi::where('status', 'terverifikasi')->sum('uang_keluar');

    // Sisa donasi yang tersedia
    $donasiTersedia = $totalDonasi - $totalPenyaluran;

    // Jika uang_keluar melebihi donasi tersedia, tolak input
    if ($this->uang_keluar > $donasiTersedia) {
        session()->flash('error', 'Jumlah penyaluran melebihi donasi yang tersedia!');
        return;
    }

    try {
        $data = [
            'tanggal' => $this->tanggal,
            'uang_keluar' => $this->uang_keluar,
            'alamat' => $this->alamat,
            'jml_kpl_keluarga' => $this->jml_kpl_keluarga,
            'nama_kk' => $this->nama_kk ? json_encode(array_map('trim', explode(',', $this->nama_kk))) : null,
            'keterangan' => $this->keterangan,
            'status' => $this->status_penyaluran,
        ];

        PenyaluranDonasi::create($data);
        session()->flash('success', 'Data penyaluran berhasil ditambahkan!');

        $this->closeModalPenyaluran();
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function verifikasiPenyaluran($id)
    {
        try {
            $penyaluran = PenyaluranDonasi::find($id);
            $penyaluran->update(['status' => 'terverifikasi']);
            session()->flash('success', 'Penyaluran berhasil diverifikasi!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat verifikasi penyaluran.');
        }
    }

    public function deletePenyaluran($id)
    {
        try {
            PenyaluranDonasi::find($id)->delete();
            session()->flash('success', 'Data penyaluran berhasil dihapus!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    // Reset filters
    public function resetFilterDonasi()
    {
        $this->searchDonasi = '';
        $this->filterBulanDonasi = '';
        $this->filterTahunDonasi = date('Y');
        $this->filterStatusDonasi = '';
        $this->resetPage();
    }

    public function resetFilterPenyaluran()
    {
        $this->searchPenyaluran = '';
        $this->filterBulanPenyaluran = '';
        $this->filterTahunPenyaluran = '';
        $this->filterStatusPenyaluran = '';
        $this->resetPage();
    }

    public function render()
    {
        // Query Donasi
        $donasisQuery = DonasiModel::query();
        
        if ($this->searchDonasi) {
            $donasisQuery->where('nama_donatur', 'like', '%' . $this->searchDonasi . '%')
                        ->orWhere('email', 'like', '%' . $this->searchDonasi . '%');
        }
        
        if ($this->filterBulanDonasi) {
            $donasisQuery->whereMonth('created_at', $this->filterBulanDonasi);
        }
        
        if ($this->filterTahunDonasi) {
            $donasisQuery->whereYear('created_at', $this->filterTahunDonasi);
        }
        
        if ($this->filterStatusDonasi) {
            $donasisQuery->where('status', $this->filterStatusDonasi);
        }

        $donasis = $donasisQuery->orderBy('created_at', 'desc')->paginate(10, ['*'], 'donasi-page');

        // Query Penyaluran
        $penyaluransQuery = PenyaluranDonasi::query();
        
        if ($this->searchPenyaluran) {
            $penyaluransQuery->where('alamat', 'like', '%' . $this->searchPenyaluran . '%')
                           ->orWhere('keterangan', 'like', '%' . $this->searchPenyaluran . '%');
        }
        
        if ($this->filterBulanPenyaluran) {
            $penyaluransQuery->whereMonth('tanggal', $this->filterBulanPenyaluran);
        }
        
        if ($this->filterTahunPenyaluran) {
            $penyaluransQuery->whereYear('tanggal', $this->filterTahunPenyaluran);
        }
        
        if ($this->filterStatusPenyaluran) {
            $penyaluransQuery->where('status', $this->filterStatusPenyaluran);
        }

        $penyalurans = $penyaluransQuery->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'penyaluran-page');

        return view('livewire.admin.donasi', compact('donasis', 'penyalurans'));
    }
}
