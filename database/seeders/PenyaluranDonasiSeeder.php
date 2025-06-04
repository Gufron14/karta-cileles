<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenyaluranDonasi;
use Faker\Factory as Faker;

class PenyaluranDonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            PenyaluranDonasi::create([
                'tanggal' => $faker->dateTimeBetween('-3 months', 'now'),
                'uang_keluar' => $faker->numberBetween(100000, 2000000),
                'alamat' => $faker->address,
                'jml_kpl_keluarga' => $faker->numberBetween(5, 50),
                'keterangan' => $faker->sentence(8),
                'status' => $faker->randomElement(['pending', 'terverifikasi']),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
