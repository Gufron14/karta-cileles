<?php

namespace Database\Seeders;

use App\Models\Pakaian;
use Illuminate\Database\Seeder;

class PakaianSeeder extends Seeder
{
    public function run(): void
    {
        $pakaians = [
            [
                'jenis_pakaian' => 'Baju Kaos',
                'jumlah_pakaian' => 25,
                'nama_donatur' => 'Ahmad Wijaya',
                'tanggal' => '2024-01-15',
                'status' => 'terverifikasi'
            ],
            [
                'jenis_pakaian' => 'Celana Jeans',
                'jumlah_pakaian' => 15,
                'nama_donatur' => 'Siti Nurhaliza',
                'tanggal' => '2024-01-20',
                'status' => 'pending'
            ],
            [
                'jenis_pakaian' => 'Jaket',
                'jumlah_pakaian' => 10,
                'nama_donatur' => 'Budi Santoso',
                'tanggal' => '2024-02-01',
                'status' => 'terverifikasi'
            ],
            [
                'jenis_pakaian' => 'Kemeja',
                'jumlah_pakaian' => 20,
                'nama_donatur' => 'Rina Kartika',
                'tanggal' => '2024-02-10',
                'status' => 'pending'
            ]
        ];

        foreach ($pakaians as $pakaian) {
            Pakaian::create($pakaian);
        }
    }
}
