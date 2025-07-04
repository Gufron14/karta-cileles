<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenyaluranPakaian;
use Faker\Factory as Faker;

class PenyaluranPakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            PenyaluranPakaian::create([
                'p_laki' => $faker->numberBetween(5, 30),
                'p_perempuan' => $faker->numberBetween(5, 30),
                'p_anak' => $faker->numberBetween(10, 40),
                'tanggal' => $faker->dateTimeBetween('-3 months', 'now'),
                'status' => $faker->randomElement(['pending', 'disalurkan']),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
