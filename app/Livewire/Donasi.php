<?php

namespace App\Livewire;

use App\Models\Donasi as DonasiModel;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('Bantuan Donasi')]
class Donasi extends Component
{
    use WithFileUploads;

    public $nama_donatur = '';
    public $email = '';
    public $no_hp = '';
    public $nominal = '';
    public $bukti_transfer;
    public $catatan = '';
    public $showSuccess = false;

    protected $rules = [
        'nama_donatur' => 'required|min:3|max:255',
        'email' => 'required|email|max:255',
        'no_hp' => 'required|numeric|digits_between:10,15',
        'nominal' => 'required|numeric|min:1000',
        'bukti_transfer' => 'required|image|max:2048', // max 2MB
        'catatan' => 'nullable|max:500',
    ];

    protected $messages = [
        'nama_donatur.required' => 'Nama lengkap wajib diisi.',
        'nama_donatur.min' => 'Nama lengkap minimal 3 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'no_hp.required' => 'Nomor telepon wajib diisi.',
        'no_hp.numeric' => 'Nomor telepon harus berupa angka.',
        'no_hp.digits_between' => 'Nomor telepon harus 10-15 digit.',
        'nominal.required' => 'Nominal donasi wajib diisi.',
        'nominal.numeric' => 'Nominal donasi harus berupa angka.',
        'nominal.min' => 'Nominal donasi minimal Rp 1.000.',
        'bukti_transfer.required' => 'Bukti transfer wajib diupload.',
        'bukti_transfer.image' => 'File harus berupa gambar.',
        'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
        'catatan.max' => 'Catatan maksimal 500 karakter.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submitDonasi()
    {
        $this->validate();

        try {
            // Upload file bukti transfer
            $buktiTransferPath = $this->bukti_transfer->store('bukti-transfer', 'public');

            // Simpan data donasi
            DonasiModel::create([
                'nama_donatur' => $this->nama_donatur,
                'email' => $this->email,
                'no_hp' => $this->no_hp,
                'nominal' => $this->nominal,
                'bukti_transfer' => $buktiTransferPath,
                'catatan' => $this->catatan,
                'status' => 'pending', // default status
            ]);

            // Reset form
            $this->reset(['nama_donatur', 'email', 'no_hp', 'nominal', 'bukti_transfer', 'catatan']);
            
            // Show success message
            $this->showSuccess = true;
            
            // Hide success message after 5 seconds
            $this->dispatch('hide-success-alert');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan donasi. Silakan coba lagi.');
        }
    }

    public function hideSuccessAlert()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.donasi');
    }
}
