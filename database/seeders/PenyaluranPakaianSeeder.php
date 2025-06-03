<?php

namespace Database\Seeders;

use App\Models\PenyaluranPakaian;
use Illuminate\Database\Seeder;

class PenyaluranPakaianSeeder extends Seeder
{
    public function run(): void
    {
        $penyalurans = [
            [
                'p_laki' => 15,
                'p_perempuan' => 20,
                'p_anak' => 10,
                'tanggal' => '2025-01-15',
                'status' => 'disalurkan'
            ],
            [
                'p_laki' => 8,
                'p_perempuan' => 12,
                'p_anak' => 5,
                'tanggal' => '2025-01-20',
                'status' => 'pending'
            ],
            [
                'p_laki' => 25,
                'p_perempuan' => 30,
                'p_anak' => 15,
                'tanggal' => '2025-02-01',
                'status' => 'disalurkan'
            ]
        ];

        foreach ($penyalurans as $penyaluran) {
            PenyaluranPakaian::create($penyaluran);
        }
    }
}
