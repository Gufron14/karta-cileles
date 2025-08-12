<?php

namespace App\Livewire\Admin\Makanan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PenyaluranMakanan as PenyaluranMakananModel;

#[Title('Tambah Penyaluran Makanan')]
#[Layout('components.layouts.admin-layout')]
class CreatePenyaluranMakanan extends Component
{
    // Form properties
    public $jumlah = 0;
    public $alamat = '';
    public $jml_kk = 0;
    public $tanggal;
    public $status = 'pending';
    
    // Dynamic KK fields
    public $kk_data = [
        ['nama_kk' => '', 'nomor_kk' => '']
    ];

    protected $rules = [
        'jumlah' => 'required|integer|min:1',
        'alamat' => 'required|string|max:255',
        'jml_kk' => 'required|integer|min:1',
        'tanggal' => 'required|date',
        'status' => 'required|in:pending,disalurkan',
        'kk_data.*.nama_kk' => 'required|string|max:255',
        'kk_data.*.nomor_kk' => 'required|string|max:20',
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
        'kk_data.*.nama_kk.required' => 'Nama KK harus diisi',
        'kk_data.*.nama_kk.max' => 'Nama KK maksimal 255 karakter',
        'kk_data.*.nomor_kk.required' => 'Nomor KK harus diisi',
        'kk_data.*.nomor_kk.max' => 'Nomor KK maksimal 20 karakter',
    ];

    public function mount()
    {
        $this->tanggal = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.makanan.create-penyaluran-makanan');
    }

    public function addKK()
    {
        $this->kk_data[] = ['nama_kk' => '', 'nomor_kk' => ''];
    }

    public function removeKK($index)
    {
        if (count($this->kk_data) > 1) {
            unset($this->kk_data[$index]);
            $this->kk_data = array_values($this->kk_data);
        }
    }

    public function store()
    {
        $this->validate();

        // Prepare data for storage
        $nama_kk_array = array_column($this->kk_data, 'nama_kk');
        $nomor_kk_array = array_column($this->kk_data, 'nomor_kk');

        PenyaluranMakananModel::create([
            'jumlah' => $this->jumlah,
            'alamat' => $this->alamat,
            'jml_kk' => $this->jml_kk,
            'nama_kk' => json_encode($nama_kk_array),
            'nomor_kk' => json_encode($nomor_kk_array),
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Data penyaluran makanan berhasil ditambahkan!');
        return redirect()->route('admin.penyaluran-makanan');
    }

    public function cancel()
    {
        return redirect()->route('admin.penyaluran-makanan');
    }
}