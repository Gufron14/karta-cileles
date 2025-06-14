<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Donasi;
use App\Models\PenyaluranDonasi;
use App\Models\Pakaian;
use App\Models\PenyaluranPakaian;
use App\Models\Makanan;
use App\Models\PenyaluranMakanan;
use App\Models\Relawan;
use App\Models\User;

#[Title('Dashboard Karang Taruna Cileles')]
#[Layout('components.layouts.admin-layout')]

class Dashboard extends Component
{
    public $totalDonasiTerkumpul;
    public $totalDonasiDisalurkan;
    public $totalPakaianTerkumpul;
    public $totalPakaianDisalurkan;
    public $totalMakananTerkumpul;
    public $totalMakananDisalurkan;
    public $totalRelawan;
    public $totalDonatur;

    public $totalDonasiTersedia = 0;

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        // Total donasi terkumpul (status approved/confirmed)
        $this->totalDonasiTerkumpul = Donasi::where('status', 'terverifikasi')
            ->orWhere('status', 'terverifikasi')
            ->sum('nominal');

        // Total donasi disalurkan
        $this->totalDonasiDisalurkan = PenyaluranDonasi::where('status', 'terverifikasi')
            ->orWhere('status', 'terverifikasi')
            ->sum('uang_keluar');

        $this->totalDonasiTersedia = $this->totalDonasiTerkumpul - $this->totalDonasiDisalurkan;

        // Total pakaian terkumpul
        $this->totalPakaianTerkumpul = Pakaian::where('status', 'terverifikasi')
            ->orWhere('status', 'terverifikasi')
            ->sum('jumlah_pakaian');

        // Total pakaian disalurkan
        $pakaianDisalurkan = PenyaluranPakaian::where('status', 'disalurkan')
            ->orWhere('status', 'disalurkan')
            ->get();
        
        $this->totalPakaianDisalurkan = $pakaianDisalurkan->sum(function($item) {
            return $item->p_laki + $item->p_perempuan + $item->p_anak;
        });

        // Total makanan/sembako terkumpul
        $this->totalMakananTerkumpul = Makanan::where('status', 'terverifikasi')
            ->orWhere('status', 'terverifikasi')
            ->sum('jumlah_makanan');

        // Total makanan/sembako disalurkan
        $this->totalMakananDisalurkan = PenyaluranMakanan::where('status', 'disalurkan')
            ->orWhere('status', 'disalurkan')
            ->sum('jumlah');

        // Total relawan
        $this->totalRelawan = Relawan::where('status', 'aktif')->count();

        // Total donatur (unique dari tabel donasi)
        $this->totalDonatur = Donasi::distinct('email')->count('email');
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
