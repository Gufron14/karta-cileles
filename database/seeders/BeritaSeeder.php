<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Bencana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Indonesian locale

        // Pastikan ada data bencana terlebih dahulu
        $bencanaIds = Bencana::pluck('id')->toArray();
        
        if (empty($bencanaIds)) {
            // Jika belum ada data bencana, buat beberapa sample
            $bencanaIds = [1, 2, 3]; // Sesuaikan dengan ID bencana yang ada
        }

        // Array gambar yang tersedia di folder public
        $availableImages = [
            'bantuan 1.png',
            'assets/img/undraw_posting_photo.svg',
            // Tambahkan gambar lain yang ada di folder public
        ];

        $beritas = [
            [
                'judul' => 'Banjir Bandang Melanda Desa Cileles, Warga Diungsikan',
                'isi' => $faker->paragraphs(5, true),
                'thumbnail' => $availableImages[0],
                'is_published' => true,
            ],
            [
                'judul' => 'Tim Relawan Karang Taruna Distribusikan Bantuan untuk Korban Bencana',
                'isi' => $faker->paragraphs(4, true),
                'thumbnail' => $availableImages[1],
                'is_published' => true,
            ],
            [
                'judul' => 'Pelatihan Siaga Bencana untuk Masyarakat Desa Cileles',
                'isi' => $faker->paragraphs(6, true),
                'thumbnail' => $availableImages[0],
                'is_published' => true,
            ],
            [
                'judul' => 'Gotong Royong Pembersihan Pasca Banjir di Wilayah Terdampak',
                'isi' => $faker->paragraphs(4, true),
                'thumbnail' => $availableImages[1],
                'is_published' => false,
            ],
            [
                'judul' => 'Sosialisasi Sistem Peringatan Dini Bencana Alam',
                'isi' => $faker->paragraphs(5, true),
                'thumbnail' => $availableImages[0],
                'is_published' => true,
            ],
        ];

        foreach ($beritas as $beritaData) {
            Berita::create([
                'bencana_id' => $faker->randomElement($bencanaIds),
                'judul' => $beritaData['judul'],
                'isi' => $beritaData['isi'],
                'slug' => Str::slug($beritaData['judul']),
                'thumbnail' => $beritaData['thumbnail'],
                'is_published' => $beritaData['is_published'],
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
