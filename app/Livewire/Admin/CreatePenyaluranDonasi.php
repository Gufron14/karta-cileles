<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PenyaluranDonasi;
use App\Models\Donasi as DonasiModel;

#[Title('Tambah Penyaluran Donasi')]
#[Layout('components.layouts.admin-layout')]
class CreatePenyaluranDonasi extends Component
{
    public $tanggal;
    public $uang_keluar = '';
    public $alamat = '';
    public $jml_kpl_keluarga = 1;
    public $keterangan = '';
    public $status_penyaluran = 'pending';

    public $kk_data = [
        ['nama_kk' => '', 'nomor_kk' => '']
    ];

    protected $rules = [
        'tanggal' => 'required|date',
        'uang_keluar' => 'required|numeric|min:1000',
        'alamat' => 'required|min:5|max:255',
        'jml_kpl_keluarga' => 'required|integer|min:1',
        'kk_data.*.nama_kk' => 'required|string|max:255',
        'kk_data.*.nomor_kk' => 'required|digits:16',
        'keterangan' => 'nullable|max:500',
        'status_penyaluran' => 'required|in:pending,terverifikasi',
    ];

    protected $messages = [
        'tanggal.required' => 'Tanggal harus diisi',
        'uang_keluar.required' => 'Uang keluar harus diisi',
        'uang_keluar.numeric' => 'Uang keluar harus berupa angka',
        'uang_keluar.min' => 'Minimal Rp1.000',
        'alamat.required' => 'Alamat harus diisi',
        'alamat.min' => 'Alamat terlalu pendek',
        'jml_kpl_keluarga.required' => 'Jumlah KK harus diisi',
        'jml_kpl_keluarga.integer' => 'Jumlah KK harus angka',
        'jml_kpl_keluarga.min' => 'Minimal 1 KK',
        'kk_data.*.nama_kk.required' => 'Nama KK wajib diisi',
        'kk_data.*.nomor_kk.required' => 'Nomor KK wajib diisi',
        'kk_data.*.nomor_kk.digits' => 'Nomor KK harus 16 digit',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->syncKKToJumlah();
    }

    public function render()
    {
        return view('livewire.admin.create-penyaluran-donasi');
    }

    public function updatedJmlKplKeluarga()
    {
        $this->syncKKToJumlah();
    }

    private function syncKKToJumlah(): void
    {
        $target = max(1, (int) $this->jml_kpl_keluarga);
        while (count($this->kk_data) < $target) {
            $this->kk_data[] = ['nama_kk' => '', 'nomor_kk' => ''];
        }
        while (count($this->kk_data) > $target) {
            array_pop($this->kk_data);
        }
    }

    public function addKK()
    {
        $this->kk_data[] = ['nama_kk' => '', 'nomor_kk' => ''];
        $this->jml_kpl_keluarga = count($this->kk_data);
    }

    public function removeKK($index)
    {
        if (count($this->kk_data) > 1) {
            unset($this->kk_data[$index]);
            $this->kk_data = array_values($this->kk_data);
            $this->jml_kpl_keluarga = count($this->kk_data);
        }
    }

    public function store()
    {
        $this->validate();

        // Saldo tersedia = total donasi terverifikasi - total penyaluran terverifikasi
        $totalDonasi = DonasiModel::where('status', 'terverifikasi')->sum('nominal');
        $totalPenyaluran = PenyaluranDonasi::where('status', 'terverifikasi')->sum('uang_keluar');
        $tersedia = $totalDonasi - $totalPenyaluran;

        if ($this->uang_keluar > $tersedia) {
            session()->flash('error', 'Jumlah penyaluran melebihi donasi yang tersedia!');
            return;
        }

        $namaArr = array_column($this->kk_data, 'nama_kk');
        $nomorArr = array_column($this->kk_data, 'nomor_kk');

        PenyaluranDonasi::create([
            'tanggal' => $this->tanggal,
            'uang_keluar' => $this->uang_keluar,
            'alamat' => $this->alamat,
            'jml_kpl_keluarga' => $this->jml_kpl_keluarga,
            'nama_kk' => json_encode($namaArr),
            'nomor_kk' => json_encode($nomorArr),
            'keterangan' => $this->keterangan,
            'status' => $this->status_penyaluran,
        ]);

        session()->flash('success', 'Data penyaluran donasi berhasil ditambahkan!');
        return redirect()->route('data-donasi');
    }

    public function cancel()
    {
        return redirect()->route('data-donasi');
    }
}