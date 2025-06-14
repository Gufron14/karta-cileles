<?php

namespace App\Livewire\Admin\Bencana;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Bencana;
use App\Models\DokumentasiBencana;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Kelola Bencana')]
#[Layout('components.layouts.admin-layout')]
class DaftarBencana extends Component
{
    use WithPagination, WithFileUploads;

    // Properties untuk form
    public $nama_bencana;
    public $lokasi;
    public $tanggal_kejadian;
    public $status = 'aktif';
    public $deskripsi;
    public $files = [];
    public $keterangan_files = [];

    // Properties untuk filter dan search
    public $search = '';
    public $filterStatus = '';
    public $filterTahun = '';

    // Properties untuk modal
    public $showModal = false;
    public $showDetailModal = false;
    public $editMode = false;
    public $bencanaId;
    public $selectedBencana;

    protected $rules = [
        'nama_bencana' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'tanggal_kejadian' => 'required|date',
        'status' => 'required|in:aktif,selesai',
        'deskripsi' => 'nullable|string',
        'files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov,wmv|max:51200', // 50MB max
        'keterangan_files.*' => 'nullable|string|max:255'
    ];

    protected $messages = [
        'nama_bencana.required' => 'Nama bencana wajib diisi',
        'lokasi.required' => 'Lokasi wajib diisi',
        'tanggal_kejadian.required' => 'Tanggal kejadian wajib diisi',
        'files.*.mimes' => 'File harus berupa gambar (jpg, jpeg, png, gif) atau video (mp4, avi, mov, wmv)',
        'files.*.max' => 'Ukuran file maksimal 50MB'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterTahun()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedBencana = null;
    }

    public function resetForm()
    {
        $this->nama_bencana = '';
        $this->lokasi = '';
        $this->tanggal_kejadian = '';
        $this->status = 'aktif';
        $this->deskripsi = '';
        $this->files = [];
        $this->keterangan_files = [];
        $this->bencanaId = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        $bencana = Bencana::create([
            'nama_bencana' => $this->nama_bencana,
            'lokasi' => $this->lokasi,
            'tanggal_kejadian' => $this->tanggal_kejadian,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->uploadFiles($bencana);

        session()->flash('success', 'Data bencana berhasil ditambahkan');
        $this->closeModal();
    }

    public function edit($id)
    {
        $bencana = Bencana::findOrFail($id);
        
        $this->bencanaId = $bencana->id;
        $this->nama_bencana = $bencana->nama_bencana;
        $this->lokasi = $bencana->lokasi;
        $this->tanggal_kejadian = $bencana->tanggal_kejadian;
        $this->status = $bencana->status;
        $this->deskripsi = $bencana->deskripsi;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $bencana = Bencana::findOrFail($this->bencanaId);
        
        $bencana->update([
            'nama_bencana' => $this->nama_bencana,
            'lokasi' => $this->lokasi,
            'tanggal_kejadian' => $this->tanggal_kejadian,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
        ]);

        if (!empty($this->files)) {
            $this->uploadFiles($bencana);
        }

        session()->flash('success', 'Data bencana berhasil diperbarui');
        $this->closeModal();
    }

    public function delete($id)
    {
        $bencana = Bencana::findOrFail($id);
        
        // Hapus file dokumentasi
        foreach ($bencana->dokumentasi as $dok) {
            if (Storage::exists($dok->file_path)) {
                Storage::delete($dok->file_path);
            }
        }
        
        $bencana->delete();
        
        session()->flash('success', 'Data bencana berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $bencana = Bencana::findOrFail($id);
        $bencana->update([
            'status' => $bencana->status === 'aktif' ? 'selesai' : 'aktif'
        ]);

        session()->flash('success', 'Status bencana berhasil diubah');
    }

    public function showDetail($id)
    {
        $this->selectedBencana = Bencana::with('dokumentasi')->findOrFail($id);
        $this->showDetailModal = true;
    }

    public function deleteFile($fileId)
    {
        $dokumentasi = DokumentasiBencana::findOrFail($fileId);
        
        if (Storage::exists($dokumentasi->file_path)) {
            Storage::delete($dokumentasi->file_path);
        }
        
        $dokumentasi->delete();
        
        // Refresh selected bencana
        $this->selectedBencana = Bencana::with('dokumentasi')->findOrFail($this->selectedBencana->id);
        
        session()->flash('success', 'File berhasil dihapus');
    }

    private function uploadFiles($bencana)
    {
        if (!empty($this->files)) {
            foreach ($this->files as $index => $file) {
                if ($file) {
                    $extension = $file->getClientOriginalExtension();
                    $jenis_media = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']) ? 'foto' : 'video';
                    
                    $path = $file->store('dokumentasi-bencana', 'public');
                    
                    DokumentasiBencana::create([
                        'bencana_id' => $bencana->id,
                        'jenis_media' => $jenis_media,
                        'file_path' => $path,
                        'keterangan' => $this->keterangan_files[$index] ?? null
                    ]);
                }
            }
        }
    }

    public function render()
    {
        $query = Bencana::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama_bencana', 'like', '%' . $this->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterTahun) {
            $query->whereYear('tanggal_kejadian', $this->filterTahun);
        }

        $bencanas = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get available years for filter
        $tahunOptions = Bencana::selectRaw('YEAR(tanggal_kejadian) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('livewire.admin.bencana.daftar-bencana', [
            'bencanas' => $bencanas,
            'tahunOptions' => $tahunOptions
        ]);
    }
}
