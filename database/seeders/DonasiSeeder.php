<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donasi;
use Faker\Factory as Faker;

class DonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 20; $i++) {
            Donasi::create([
                'nama_donatur' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'no_hp' => '08' . $faker->numerify('##########'),
                'catatan' => $faker->sentence(10),
                'nominal' => $faker->numberBetween(50000, 5000000),
                'bukti_transfer' => 'bukti_transfer_' . $i . '.jpg',
                'status' => $faker->randomElement(['pending', 'terverifikasi']),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
