<?php

namespace App\Livewire\Admin\Makanan;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\PenyaluranMakanan as PenyaluranMakananModel;

#[Title('Edit Penyaluran Makanan')]
#[Layout('components.layouts.admin-layout')]
class EditPenyaluranMakanan extends Component
{
    public $penyaluranId;
    
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
        'kk_data.*.nomor_kk' => 'required|digits:16',
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
        'kk_data.*.nomor_kk.digits' => 'Nomor KK harus 16 digit',
    ];

    public function mount($id)
    {
        $this->penyaluranId = $id;
        $penyaluran = PenyaluranMakananModel::findOrFail($id);
        
        $this->jumlah = $penyaluran->jumlah;
        $this->alamat = $penyaluran->alamat;
        $this->jml_kk = $penyaluran->jml_kk;
        $this->tanggal = $penyaluran->tanggal;
        $this->status = $penyaluran->status;

        // Load existing KK data
        if ($penyaluran->nama_kk && $penyaluran->nomor_kk) {
            $nama_kk_array = json_decode($penyaluran->nama_kk, true) ?: [];
            $nomor_kk_array = json_decode($penyaluran->nomor_kk, true) ?: [];
            
            $this->kk_data = [];
            for ($i = 0; $i < max(count($nama_kk_array), count($nomor_kk_array)); $i++) {
                $this->kk_data[] = [
                    'nama_kk' => $nama_kk_array[$i] ?? '',
                    'nomor_kk' => $nomor_kk_array[$i] ?? ''
                ];
            }
        } elseif ($penyaluran->nama_kk) {
            // Handle old format (comma-separated string)
            $nama_kk_decoded = json_decode($penyaluran->nama_kk, true);
            if (is_array($nama_kk_decoded)) {
                $nama_kk_array = $nama_kk_decoded;
            } else {
                // Old format: comma-separated string
                $nama_kk_array = array_map('trim', explode(',', $penyaluran->nama_kk));
            }
            
            $this->kk_data = [];
            foreach ($nama_kk_array as $nama) {
                $this->kk_data[] = [
                    'nama_kk' => $nama,
                    'nomor_kk' => ''
                ];
            }
        }

        // Ensure at least one row exists and match jml_kk
        if (empty($this->kk_data)) {
            $this->kk_data = [['nama_kk' => '', 'nomor_kk' => '']];
        }
        
        // Sync kk_data count with jml_kk
        $this->updateKKFields();
    }

    public function render()
    {
        return view('livewire.admin.makanan.edit-penyaluran-makanan');
    }

    public function updatedJmlKk()
    {
        $this->updateKKFields();
    }

    public function updateKKFields()
    {
        $jml_kk = (int) $this->jml_kk;
        
        if ($jml_kk > 0) {
            // If we need more fields, add them
            while (count($this->kk_data) < $jml_kk) {
                $this->kk_data[] = ['nama_kk' => '', 'nomor_kk' => ''];
            }
            
            // If we have too many fields, remove the excess
            while (count($this->kk_data) > $jml_kk) {
                array_pop($this->kk_data);
            }
        } else {
            // If jml_kk is 0 or empty, keep at least one field
            $this->kk_data = [['nama_kk' => '', 'nomor_kk' => '']];
        }
    }

    public function addKK()
    {
        $this->kk_data[] = ['nama_kk' => '', 'nomor_kk' => ''];
        // Update jml_kk to match the number of fields
        $this->jml_kk = count($this->kk_data);
    }

    public function removeKK($index)
    {
        if (count($this->kk_data) > 1) {
            unset($this->kk_data[$index]);
            $this->kk_data = array_values($this->kk_data);
            // Update jml_kk to match the number of fields
            $this->jml_kk = count($this->kk_data);
        }
    }

    public function update()
    {
        $this->validate();

        $penyaluran = PenyaluranMakananModel::findOrFail($this->penyaluranId);

        // Prepare data for storage
        $nama_kk_array = array_column($this->kk_data, 'nama_kk');
        $nomor_kk_array = array_column($this->kk_data, 'nomor_kk');

        $penyaluran->update([
            'jumlah' => $this->jumlah,
            'alamat' => $this->alamat,
            'jml_kk' => $this->jml_kk,
            'nama_kk' => json_encode($nama_kk_array),
            'nomor_kk' => json_encode($nomor_kk_array),
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Data penyaluran makanan berhasil diperbarui!');
        return redirect()->route('penyaluran-makanan');
    }

    public function cancel()
    {
        return redirect()->route('penyaluran-makanan');
    }
}