<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Makanan;
use Faker\Factory as Faker;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $jenisMakanan = [
            'Beras', 'Minyak Goreng', 'Gula Pasir', 'Teh', 'Kopi',
            'Mie Instan', 'Sardines', 'Susu Kental Manis', 'Tepung Terigu',
            'Kecap Manis', 'Sambal Sachet', 'Bumbu Masak', 'Telur'
        ];
        
        for ($i = 1; $i <= 20; $i++) {
            Makanan::create([
                'jenis_makanan' => $faker->randomElement($jenisMakanan),
                'jumlah_makanan' => $faker->numberBetween(10, 200),
                'nama_donatur' => $faker->name,
                'tanggal' => $faker->dateTimeBetween('-6 months', 'now'),
                'status' => $faker->randomElement(['pending', 'terverifikasi']),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
