<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenyaluranMakanan;
use Faker\Factory as Faker;

class PenyaluranMakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            PenyaluranMakanan::create([
                'jumlah' => $faker->numberBetween(10, 100),
                'alamat' => $faker->address,
                'jml_kk' => $faker->numberBetween(5, 50),
                'tanggal' => $faker->dateTimeBetween('-3 months', 'now'),
                'status' => $faker->randomElement(['pending', 'disalurkan']),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
