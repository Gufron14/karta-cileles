<?php

namespace Database\Seeders;

use App\Models\Bencana;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BencanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $jenisBencana = [
            'Banjir',
            'Gempa Bumi',
            'Tanah Longsor',
            'Kebakaran Hutan',
            'Angin Puting Beliung',
            'Kekeringan',
            'Tsunami',
            'Erupsi Gunung Berapi',
            'Kebakaran Permukiman',
            'Banjir Bandang'
        ];

        $statusOptions = ['Aktif', 'Selesai'];

        foreach ($jenisBencana as $index => $jenis) {
            Bencana::create([
                'nama_bencana' => $jenis . ' ' . $faker->city(),
                'lokasi' => $faker->address(),
                'tanggal_kejadian' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'status' => $faker->randomElement($statusOptions),
                'deskripsi' => $faker->optional(0.8)->paragraph(3) // 80% kemungkinan ada deskripsi
            ]);
        }
    }
}
