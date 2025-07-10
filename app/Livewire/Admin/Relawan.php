<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Relawan as RelawanModel;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Data Relawan Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]
class Relawan extends Component
{
    use WithPagination;

    public $selectedRelawan;
    public $search = '';
    public $filterJenisKelamin = '';
    public $filterStatus = '';
    public $filterAlamat = '';

    // Fungsi untuk menambah dan mengedit relawan
    public $isEdit = false;
    public $relawanId;
    public $nama_lengkap;
    public $email;
    public $no_hp;
    public $alamat;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $pendidikan_terakhir;
    public $usia;
    public $ketertarikan;
    public $kegiatan;
    public $dokumentasi;
    public $status;

    // Pagination Bootsrap
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'nama_lengkap' => 'required|min:3',
        'email' => 'required|email',
        'no_hp' => 'required|string|min:10|max:13',
        'alamat' => 'required|min:10',
        'jenis_kelamin' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'pendidikan_terakhir' => 'required',
        'usia' => 'required',
        'ketertarikan' => 'required|min:20',
        'kegiatan' => 'required|min:20',
        'dokumentasi' => 'required|min:10',
        'status' => 'required',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->isEdit = false;
    }

    public function editRelawan($id)
    {
        $relawan = RelawanModel::find($id);
        $this->relawanId = $relawan->id;
        $this->nama_lengkap = $relawan->nama_lengkap;
        $this->email = $relawan->email;
        $this->no_hp = $relawan->no_hp;
        $this->alamat = $relawan->alamat;
        $this->jenis_kelamin = $relawan->jenis_kelamin;
        $this->tempat_lahir = $relawan->tempat_lahir;
        $this->tanggal_lahir = $relawan->tanggal_lahir;
        $this->pendidikan_terakhir = $relawan->pendidikan_terakhir;
        $this->usia = $relawan->usia;
        $this->ketertarikan = $relawan->ketertarikan;
        $this->kegiatan = $relawan->kegiatan;
        $this->dokumentasi = $relawan->dokumentasi;
        $this->status = $relawan->status;
        $this->isEdit = true;
    }

    public function saveRelawan()
    {
        $this->validate();

        if ($this->isEdit) {
            RelawanModel::find($this->relawanId)->update([
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'jenis_kelamin' => $this->jenis_kelamin,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'pendidikan_terakhir' => $this->pendidikan_terakhir,
                'usia' => $this->usia,
                'ketertarikan' => $this->ketertarikan,
                'kegiatan' => $this->kegiatan,
                'dokumentasi' => $this->dokumentasi,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Data relawan berhasil diupdate');
        } else {
            RelawanModel::create([
                'nama_lengkap' => $this->nama_lengkap,
                'email' => $this->email,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'jenis_kelamin' => $this->jenis_kelamin,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'pendidikan_terakhir' => $this->pendidikan_terakhir,
                'usia' => $this->usia,
                'ketertarikan' => $this->ketertarikan,
                'kegiatan' => $this->kegiatan,
                'dokumentasi' => $this->dokumentasi,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Data relawan berhasil ditambahkan');
        }

        $this->resetForm();
        $this->dispatch('closeModal');
    }

    public function resetForm()
    {
        $this->relawanId = null;
        $this->nama_lengkap = '';
        $this->email = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->jenis_kelamin = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->pendidikan_terakhir = '';
        $this->usia = '';
        $this->ketertarikan = '';
        $this->kegiatan = '';
        $this->dokumentasi = '';
        $this->status = '';
        $this->resetErrorBag();
    }

    public function showDetail($id)
    {
        $this->selectedRelawan = RelawanModel::find($id);
    }

    public function updateStatus($id, $status)
    {
        $relawan = RelawanModel::find($id);
        $relawan->update(['status' => $status]);

        session()->flash('message', 'Status relawan berhasil diupdate');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterJenisKelamin()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterAlamat()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->filterJenisKelamin = '';
        $this->filterStatus = '';
        $this->filterAlamat = '';
        $this->resetPage();
    }

    // Fungsi untuk menambah dan mengedit relawan

    public function render()
    {
        $query = RelawanModel::query();

        // Filter pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_lengkap', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Filter jenis kelamin
        if ($this->filterJenisKelamin) {
            $query->where('jenis_kelamin', $this->filterJenisKelamin);
        }

        // Filter status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Filter alamat
        if ($this->filterAlamat) {
            $query->where('alamat', 'like', '%' . $this->filterAlamat . '%');
        }

        $relawans = $query->paginate(10);

        // Data untuk dropdown filter alamat
        $alamatOptions = RelawanModel::select('alamat')
            ->distinct()
            ->orderBy('alamat')
            ->pluck('alamat')
            ->map(function ($alamat) {
                return [
                    'value' => $alamat,
                    'label' => Str::limit($alamat, 30),
                ];
            });

        return view('livewire.admin.relawan', compact('relawans', 'alamatOptions'));
    }
}
