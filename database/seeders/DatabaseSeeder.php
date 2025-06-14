<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BencanaSeeder::class,
            BeritaSeeder::class,
            DonasiSeeder::class,
            PenyaluranDonasiSeeder::class,
            PakaianSeeder::class,
            PenyaluranPakaianSeeder::class,
            MakananSeeder::class,
            PenyaluranMakananSeeder::class,
            RelawanSeeder::class,
        ]);

        $faqs = [
            [
                'pertanyaan' => 'Apa itu Karang Taruna Cileles?',
                'jawaban' => 'Karang Taruna Cileles adalah organisasi kepemudaan di tingkat desa yang bergerak dalam bidang kesejahteraan sosial, khususnya dalam penanggulangan bencana dan pemberdayaan masyarakat di Desa Cileles.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara menjadi relawan di Karang Taruna Cileles?',
                'jawaban' => 'Anda dapat mendaftar sebagai relawan melalui website ini dengan mengisi formulir pendaftaran relawan. Setelah itu, tim kami akan menghubungi Anda untuk proses selanjutnya.'
            ],
            [
                'pertanyaan' => 'Apa saja kegiatan yang dilakukan Karang Taruna Cileles?',
                'jawaban' => 'Kegiatan kami meliputi tanggap darurat bencana, distribusi bantuan (makanan, pakaian, donasi), pelatihan siaga bencana, gotong royong pembersihan, dan sosialisasi sistem peringatan dini.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara berdonasi untuk korban bencana?',
                'jawaban' => 'Anda dapat berdonasi melalui website ini dengan memilih program donasi yang tersedia. Donasi dapat berupa uang, makanan, pakaian, atau barang kebutuhan lainnya.'
            ],
            [
                'pertanyaan' => 'Apakah ada pelatihan untuk menjadi relawan?',
                'jawaban' => 'Ya, kami menyediakan pelatihan dasar untuk relawan baru meliputi penanganan darurat, distribusi bantuan, komunikasi dengan korban bencana, dan koordinasi tim.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara melaporkan bencana atau keadaan darurat?',
                'jawaban' => 'Anda dapat melaporkan melalui kontak darurat yang tersedia di website ini, atau langsung menghubungi kantor Karang Taruna Cileles. Tim kami siap 24/7 untuk merespons keadaan darurat.'
            ],
            [
                'pertanyaan' => 'Apakah bantuan yang diberikan gratis?',
                'jawaban' => 'Ya, semua bantuan yang kami distribusikan kepada korban bencana adalah gratis. Bantuan berasal dari donasi masyarakat dan program pemerintah yang kami salurkan.'
            ],
            [
                'pertanyaan' => 'Bagaimana transparansi penggunaan donasi?',
                'jawaban' => 'Kami berkomitmen untuk transparansi penuh. Laporan penggunaan donasi dipublikasikan secara berkala di website ini dan dapat diakses oleh semua donatur dan masyarakat.'
            ],
            // [
            //     'pertanyaan' => 'Apakah Karang Taruna Cileles bekerja sama dengan pihak lain?',
            //     'jawaban' => 'Ya, kami bekerja sama dengan BPBD, PMI, TNI/Polri, organisasi kemanusiaan lainnya, dan pemerintah daerah untuk memberikan bantuan yang optimal kepada masyarakat.'
            // ],
            [
                'pertanyaan' => 'Bagaimana cara mendapatkan informasi terbaru tentang kegiatan Karang Taruna?',
                'jawaban' => 'Anda dapat mengikuti informasi terbaru melalui website ini, media sosial kami, atau berlangganan newsletter untuk mendapatkan update kegiatan dan program terbaru.'
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
