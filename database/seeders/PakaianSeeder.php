<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pakaian;
use Faker\Factory as Faker;

class PakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $jenisPakaian = [
            'Baju Anak', 'Baju Dewasa', 'Celana Anak', 'Celana Dewasa',
            'Kemeja', 'Kaos', 'Jaket', 'Rok', 'Dress', 'Sweater'
        ];
        
        for ($i = 1; $i <= 20; $i++) {
            Pakaian::create([
                'jenis_pakaian' => $faker->randomElement($jenisPakaian),
                'jumlah_pakaian' => $faker->numberBetween(5, 100),
                'nama_donatur' => $faker->name,
                'tanggal' => $faker->dateTimeBetween('-6 months', 'now'),
                'status' => $faker->randomElement(['pending', 'terverifikasi']),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
