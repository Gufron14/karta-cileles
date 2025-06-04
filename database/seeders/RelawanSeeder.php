<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Relawan;
use Faker\Factory as Faker;

class RelawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $pendidikan = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'];
        $ketertarikan = [
            'Sosial Kemasyarakatan', 'Pendidikan', 'Kesehatan', 'Lingkungan',
            'Pemberdayaan Ekonomi', 'Olahraga', 'Seni dan Budaya', 'Teknologi'
        ];
        $kegiatan = [
            'Bakti Sosial', 'Gotong Royong', 'Penyuluhan', 'Pelatihan',
            'Pembagian Sembako', 'Kerja Bakti', 'Event Komunitas', 'Fundraising'
        ];
        
        for ($i = 1; $i <= 20; $i++) {
            $tanggalLahir = $faker->dateTimeBetween('-50 years', '-17 years');
            $usia = now()->year - $tanggalLahir->format('Y');
            
            Relawan::create([
                'nama_lengkap' => $faker->name,
                'no_hp' => '08' . $faker->numerify('##########'),
                'email' => $faker->unique()->safeEmail,
                'alamat' => $faker->address,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $tanggalLahir->format('Y-m-d'),
                'pendidikan_terakhir' => $faker->randomElement($pendidikan),
                'usia' => $usia,
                'ketertarikan' => $faker->randomElement($ketertarikan),
                'kegiatan' => $faker->randomElement($kegiatan),
                'dokumentasi' => 'dokumentasi_relawan_' . $i . '.jpg',
                'status' => $faker->randomElement(['aktif', 'pasif']),
            ]);
        }
    }
}
