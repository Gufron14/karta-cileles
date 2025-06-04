<?php

namespace App\Livewire;

use App\Models\Donasi;
use App\Models\Relawan;
use App\Models\Makanan;
use App\Models\Pakaian;
use App\Models\PenyaluranDonasi;
use App\Models\PenyaluranPakaian;
use App\Models\PenyaluranMakanan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Karang Taruna Cileles')]
class Home extends Component
{
    public function render()
    {
        // Statistik Dana
        $totalDanaTerkumpul = Donasi::where('status', 'terverifikasi')->sum('nominal');
        $totalDonatur = Donasi::where('status', 'terverifikasi')->distinct('email')->count();
        $totalDanaDisalurkan = PenyaluranDonasi::where('status', 'terverifikasi')->sum('uang_keluar');
        $sisaDana = $totalDanaTerkumpul - $totalDanaDisalurkan;

        // Statistik Relawan
        $totalRelawan = Relawan::count();
        $relawanAktif = Relawan::where('status', 'aktif')->count();

        // Statistik Makanan
        $totalMakananTerkumpul = Makanan::where('status', 'terverifikasi')->sum('jumlah_makanan');
        $totalMakananDisalurkan = PenyaluranMakanan::where('status', 'disalurkan')->sum('jumlah');
        $sisaMakanan = $totalMakananTerkumpul - $totalMakananDisalurkan;

        // Statistik Pakaian
        $totalPakaianTerkumpul = Pakaian::where('status', 'terverifikasi')->sum('jumlah_pakaian');
        $totalPakaianDisalurkan = PenyaluranPakaian::where('status', 'disalurkan')->sum('p_laki') + 
                                 PenyaluranPakaian::where('status', 'disalurkan')->sum('p_perempuan') + 
                                 PenyaluranPakaian::where('status', 'disalurkan')->sum('p_anak');
        $sisaPakaian = $totalPakaianTerkumpul - $totalPakaianDisalurkan;

        // Total Keluarga yang Terbantu
        $totalKeluargaTerbantu = PenyaluranDonasi::where('status', 'approved')->sum('jml_kpl_keluarga') +
                                PenyaluranMakanan::where('status', 'approved')->sum('jml_kk');

        return view('livewire.home', [
            'totalDanaTerkumpul' => $totalDanaTerkumpul,
            'totalDonatur' => $totalDonatur,
            'totalDanaDisalurkan' => $totalDanaDisalurkan,
            'sisaDana' => $sisaDana,
            'totalRelawan' => $totalRelawan,
            'relawanAktif' => $relawanAktif,
            'totalMakananTerkumpul' => $totalMakananTerkumpul,
            'totalMakananDisalurkan' => $totalMakananDisalurkan,
            'sisaMakanan' => $sisaMakanan,
            'totalPakaianTerkumpul' => $totalPakaianTerkumpul,
            'totalPakaianDisalurkan' => $totalPakaianDisalurkan,
            'sisaPakaian' => $sisaPakaian,
            'totalKeluargaTerbantu' => $totalKeluargaTerbantu,
        ]);
    }
}
