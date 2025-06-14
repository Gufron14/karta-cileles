<?php

namespace App\Livewire\Admin\Bencana;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Bencana;
use App\Models\DokumentasiBencana as  DokumentasiBencanaModel;;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Dokumentasi Bencana')]
#[Layout('components.layouts.admin-layout')]

class DokumentasiBencana extends Component
{
    use WithFileUploads;

    public $bencana_id = '';
    public $jenis_media = 'foto';
    public $media_files = [];
    public $keterangan = '';
    public $editId = null;

    public $search = '';
    public $bencanaFilter = '';

    protected $rules = [
        'bencana_id' => 'required|exists:bencanas,id',
        'jenis_media' => 'required|in:foto,video',
        'media_files.*' => 'required|file|max:10240', // max 10MB per file
        'keterangan' => 'nullable|string|max:255',
    ];

    public function resetForm()
    {
        $this->reset(['bencana_id', 'jenis_media', 'media_files', 'keterangan', 'editId']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        foreach ($this->media_files as $file) {
            $path = $file->store('dokumentasi_bencana', 'public');
            DokumentasiBencanaModel::create([
                'bencana_id' => $this->bencana_id,
                'jenis_media' => $this->jenis_media,
                'file_path' => $path,
                'keterangan' => $this->keterangan,
            ]);
        }

        $this->resetForm();
        session()->flash('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = DokumentasiBencanaModel::findOrFail($id);
        $this->editId = $id;
        $this->bencana_id = $data->bencana_id;
        $this->jenis_media = $data->jenis_media;
        $this->keterangan = $data->keterangan;
        $this->media_files = [];
    }

    public function update()
    {
        $this->validate([
            'bencana_id' => 'required|exists:bencanas,id',
            'jenis_media' => 'required|in:foto,video',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data = DokumentasiBencanaModel::findOrFail($this->editId);

        // Jika ada file baru, hapus file lama dan upload baru
        if ($this->media_files) {
            Storage::disk('public')->delete($data->file_path);
            $file = $this->media_files[0];
            $path = $file->store('dokumentasi_bencana', 'public');
            $data->update([
                'file_path' => $path,
            ]);
        }

        $data->update([
            'bencana_id' => $this->bencana_id,
            'jenis_media' => $this->jenis_media,
            'keterangan' => $this->keterangan,
        ]);

        $this->resetForm();
        session()->flash('success', 'Dokumentasi berhasil diperbarui!');
    }

    public function delete($id)
    {
        $data = DokumentasiBencanaModel::findOrFail($id);
        Storage::disk('public')->delete($data->file_path);
        $data->delete();
        session()->flash('success', 'Dokumentasi berhasil dihapus!');
    }

public function render()
{
    $bencanas = Bencana::orderBy('tanggal_kejadian', 'desc')->get();

    $query = DokumentasiBencanaModel::query()->with('bencana');
    if ($this->search) {
        $query->where('keterangan', 'like', '%' . $this->search . '%');
    }
    if ($this->bencanaFilter) {
        $query->where('bencana_id', $this->bencanaFilter);
    }
    $dokumentasis = $query->orderBy('created_at', 'desc')->get();

    // Kelompokkan berdasarkan bencana_id dan keterangan
    $grouped = $dokumentasis->groupBy(function($item) {
        return $item->bencana_id . '||' . ($item->keterangan ?? '');
    });

    return view('livewire.admin.bencana.dokumentasi-bencana', [
        'bencanas' => $bencanas,
        'groupedDokumentasi' => $grouped,
    ]);
}
}