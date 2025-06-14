<?php

namespace App\Livewire;

use App\Models\Relawan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Formulir Pendaftaran Relawan')]

class FormRelawan extends Component
{
    public $email;
    public $nama_lengkap;
    public $no_hp;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat;
    public $usia;
    public $pendidikan_terakhir;
    public $jenis_kelamin;
    public $ketertarikan;
    public $kegiatan;
    public $dokumentasi;

    protected $rules = [
        'email' => 'required|email|unique:relawans,email',
        'nama_lengkap' => 'required|min:3',
        'no_hp' => 'required|numeric|min:10',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|min:10',
        'usia' => 'required',
        'pendidikan_terakhir' => 'required',
        'jenis_kelamin' => 'required',
        'ketertarikan' => 'required|min:20',
        'kegiatan' => 'required|min:20',
        'dokumentasi' => 'required|min:10',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'nama_lengkap.required' => 'Nama lengkap wajib diisi',
        'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
        'no_hp.required' => 'Nomor telepon wajib diisi',
        'no_hp.numeric' => 'Nomor telepon harus berupa angka',
        'no_hp.min' => 'Nomor telepon minimal 10 digit',
        'tempat_lahir.required' => 'Tempat lahir wajib diisi',
        'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
        'tanggal_lahir.date' => 'Format tanggal tidak valid',
        'alamat.required' => 'Alamat wajib diisi',
        'alamat.min' => 'Alamat minimal 10 karakter',
        'usia.required' => 'Usia wajib dipilih',
        'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih',
        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
        'ketertarikan.required' => 'Pertanyaan motivasi wajib dijawab',
        'ketertarikan.min' => 'Jawaban motivasi minimal 20 karakter',
        'kegiatan.required' => 'Pertanyaan kontribusi wajib dijawab',
        'kegiatan.min' => 'Jawaban kontribusi minimal 20 karakter',
        'dokumentasi.required' => 'Pertanyaan dokumentasi wajib dijawab',
        'dokumentasi.min' => 'Jawaban dokumentasi minimal 10 karakter',
    ];

    public function daftar()
    {
        $this->validate();

        Relawan::create([
            'email' => $this->email,
            'nama_lengkap' => $this->nama_lengkap,
            'no_hp' => $this->no_hp,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'usia' => $this->usia,
            'pendidikan_terakhir' => $this->pendidikan_terakhir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'ketertarikan' => $this->ketertarikan,
            'kegiatan' => $this->kegiatan,
            'dokumentasi' => $this->dokumentasi,
            'status' => 'aktif'
        ]);

        session()->flash('success', 'Pendaftaran relawan berhasil! Terima kasih telah mendaftar.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.form-relawan');
    }
}
