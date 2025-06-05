<div>
    <header>
        <!-- Background image -->
        <div class="text-center bg-image"
            style="
      background-image: url('https://mdbcdn.b-cdn.net/img/new/slides/041.webp');
      height: 400px;
    ">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6); width: 100%; height: 100%;">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="col-6 text-white">
                        <h3>Relawan Karang Taruna Kecamatan Cileles</h3>
                        <h4 class="lead">
                            Dimana kumpulan pemuda-pemudi yang peduli terhadap lingkungan sosial di wilayah Kecamatan
                            Cileles. Mereka adalah generasi muda yang bergerak secara sukarela untuk membantu masyarakat
                            melalui kegiatan sosial, kepemudaan, pemberdayaan, hingga penanganan masalah sosial di
                            sekitar.
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background image -->
    </header>

    <div class="container mt-5 mb-5">
        <div class="card border-0 shadow text-center">
            <div class="card-body p-5">
                <div class="d-flex align-items-center mb-5">
                    <div class="col">
                        <h4 class="fw-bold">
                            Rp{{ number_format(\App\Models\Donasi::where('status', 'terverifikasi')->sum('nominal'), 0, ',', '.') }}
                        </h4>
                        <span>Dana Terkumpul</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">{{ \App\Models\Donasi::where('status', 'terverifikasi')->count() }}</h4>
                        <span>Donatur</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">{{ \App\Models\Relawan::where('status', 'aktif')->count() }}</h4>
                        <span>Relawan Aktif</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">
                            {{ \App\Models\Makanan::where('status', 'terverifikasi')->sum('jumlah_makanan') }}</h4>
                        <span>Makanan (Porsi)</span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="col">
                        <h4 class="fw-bold">
                            {{ \App\Models\Pakaian::where('status', 'terverifikasi')->sum('jumlah_pakaian') }}</h4>
                        <span>Pakaian (Pcs)</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">
                            Rp{{ number_format(\App\Models\PenyaluranDonasi::where('status', 'terverifikasi')->sum('uang_keluar'), 0, ',', '.') }}
                        </h4>
                        <span>Dana Tersalurkan</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">
                            {{ \App\Models\PenyaluranMakanan::where('status', 'disalurkan')->sum('jumlah') }}</h4>
                        <span>Makanan Tersalurkan</span>
                    </div>
                    |
                    <div class="col">
                        <h4 class="fw-bold">
                            {{ \App\Models\PenyaluranPakaian::where('status', 'disalurkan')->sum(\DB::raw('p_laki + p_perempuan + p_anak')) }}
                        </h4>
                        <span>Pakaian Tersalurkan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid mb-3" style="background-color: #f3f3f3;">
        <div class="container p-5">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
                <img src="{{ asset('Karang Taruna.png') }}" alt="" width="48px">
                <span class="fw-bold h4">Karang Taruna Cileles</span>
            </div>
            <h4 class="mb-4 text-center">Karang Taruna Cileles mengajak kamu untuk berdonasi atau menjadi relawan bagi
                korban berbagai bencana.
                Sekecil apa pun bantuanmu, sangat berarti untuk mereka yang membutuhkan.

                Gabung sekarang – bersama kita kuat!</h4>
            <div class="d-flex mx-auto align-items-center justify-content-center gap-3">
                <a href="{{ route('donasi') }}" class="btn btn-danger btn-lg fw-bold">Donasi Sekarang</a>
                <a href="{{ route('formRelawan') }}" class="btn btn-outline-danger btn-lg fw-bold">Gabung Relawan</a>
            </div>
        </div>
    </div>

    {{-- Portal Berita --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary mb-3">Portal Berita Terkini</h2>
                <p class="text-muted lead">Informasi terbaru seputar kegiatan dan program Karang Taruna Cileles</p>
                <div class="mx-auto bg-primary" style="width: 60px; height: 3px;"></div>
            </div>

            @if ($latestBerita || $otherBerita->count() > 0)
                <div class="row g-4">
                    {{-- Highlight Berita Utama --}}
                    @if ($latestBerita)
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-lg h-100 overflow-hidden">
                                <div class="position-relative">
                                    @if ($latestBerita->thumbnail)
                                        <img src="{{ $latestBerita->thumbnail_url ?? asset('storage/' . $latestBerita->thumbnail) }}"
                                            alt="{{ $latestBerita->judul }}" class="card-img-top"
                                            style="height: 300px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}"
                                            alt="Default News Image" class="card-img-top bg-light p-4"
                                            style="height: 300px; object-fit: contain;">
                                    @endif
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="fas fa-fire me-1"></i>TERBARU
                                        </span>
                                    </div>
                                    @if ($latestBerita->bencana)
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge bg-primary fs-6 px-3 py-2">
                                                {{ $latestBerita->bencana->nama_bencana }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3 text-muted small">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <span>{{ $latestBerita->created_at->format('d M Y') }}</span>
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ $latestBerita->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h4 class="card-title fw-bold mb-3 text-dark">
                                        {{ $latestBerita->judul }}
                                    </h4>
                                    <p class="card-text text-muted mb-4">
                                        {{ Str::limit(strip_tags($latestBerita->isi), 150) }}
                                    </p>
                                    <a href="{{ route('detailBerita', $latestBerita->slug) }}"
                                        class="btn btn-primary btn-lg px-4">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Berita Lainnya --}}
                    <div class="col-lg-6">
                        <div class="row g-3 h-100">
                            @forelse($otherBerita as $berita)
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="row g-0 h-100">
                                            <div class="col-4">
                                                @if ($berita->thumbnail)
                                                    <img src="{{ $berita->thumbnail_url ?? asset('storage/' . $berita->thumbnail) }}"
                                                        alt="{{ $berita->judul }}"
                                                        class="img-fluid rounded-start h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                    <div
                                                        class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                                        <i class="fas fa-newspaper fa-2x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-8">
                                                <div class="card-body p-3 h-100 d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-2">
                                                        @if ($berita->bencana)
                                                            <span
                                                                class="badge bg-outline-primary text-primary small me-2">
                                                                {{ $berita->bencana->nama_bencana }}
                                                            </span>
                                                        @endif
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ $berita->created_at->format('d M Y') }}
                                                        </small>
                                                    </div>
                                                    <h6 class="card-title fw-bold mb-2 flex-grow-1">
                                                        <a href="{{ route('detailBerita', $berita->slug) }}"
                                                            class="text-decoration-none text-dark stretched-link">
                                                            {{ Str::limit($berita->judul, 80) }}
                                                        </a>
                                                    </h6>
                                                    <p class="card-text text-muted small mb-0">
                                                        {{ Str::limit(strip_tags($berita->isi), 80) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @if (!$latestBerita)
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada berita tersedia</h5>
                                            <p class="text-muted">Berita terbaru akan segera hadir</p>
                                        </div>
                                    </div>
                                @endif
                            @endforelse

                            {{-- Jika hanya ada 1 berita, tampilkan placeholder --}}
                            @if ($otherBerita->count() == 0 && $latestBerita)
                                <div class="col-12">
                                    <div class="card border-0 shadow-sm bg-light">
                                        <div class="card-body text-center py-4">
                                            <i class="fas fa-plus-circle fa-2x text-muted mb-3"></i>
                                            <h6 class="text-muted">Berita lainnya segera hadir</h6>
                                            <p class="text-muted small mb-0">Pantau terus untuk update terbaru</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Call to Action --}}
                <div class="d-flex gap-3 justify-content-center flex-wrap mt-5">
                    <a href="{{ route('berita') }}" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-newspaper me-2"></i>
                        Lihat Semua Berita
                    </a>
                    <a href="{{ route('formRelawan') }}" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fas fa-user-plus me-2"></i>
                        Bergabung Jadi Relawan
                    </a>
                </div>
            @else
                {{-- Empty State --}}
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center py-5">
                            <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" alt="No News"
                                class="img-fluid mb-4" style="max-width: 200px;">
                            <h4 class="fw-bold text-primary mb-3">Portal Berita Segera Hadir</h4>
                            <p class="text-muted mb-4">
                                Kami sedang menyiapkan berbagai informasi menarik seputar kegiatan Karang Taruna
                                Cileles.
                                Pantau terus untuk mendapatkan update terbaru!
                            </p>
                            <div class="d-flex gap-3 justify-content-center flex-wrap">
                                <a href="{{ route('relawan') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Daftar Relawan
                                </a>
                                <a href="{{ route('faq') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-question-circle me-2"></i>
                                    FAQ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>


    {{-- Pasca Bencana --}}
    <div class="container">
        <h4 class="fw-bold text-center py-4">Pasca Bencana</h4>
        <!-- Gallery -->
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain1.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Wintry Mountain Landscape" />
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Mountains in the Clouds" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Boat on Calm Water" />
            </div>

            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Waves at Sea" />

                <img src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                    class="w-100 shadow-1-strong rounded mb-4" alt="Yosemite National Park" />
            </div>
        </div>
        <!-- Gallery -->
        <div class="text-center mt-3">
            <a href="{{ route('berita') }}" class="btn btn-danger">
                Lihat Dokumentasi Bencana <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    {{-- Kolaborasi --}}
    <div class="container">
        <h4 class="fw-bold text-center py-4 mt-4">Kolaborasi</h4>
        <div class="row">
            <div class="col">
                <img src="{{ asset('bantuan 1.png') }}" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="col">
                <img src="{{ asset('bantuan 1.png') }}" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="col">
                <img src="{{ asset('bantuan 1.png') }}" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="col">
                <img src="{{ asset('bantuan 1.png') }}" class="img-fluid img-thumbnail" alt="">
            </div>
        </div>
    </div>


    {{-- Benefit Relawan --}}
    <div class="container mb-5 p-5">
        <h4 class="fw-bold text-center">Benefit Menjadi Relawan Karang Taruna</h4>
        <div class="row g-4 py-4 row-cols-1 row-cols-lg-3">
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('bantuan 1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Dapat membantu orang lain di masa sulit, relawan merasakan kepuasan batin
                            dan menjadikan hidup lebih bermanfaat serta bermakna.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('bantuan 1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Mengasah empati, keterampilan komunikasi, kerja sama tim, dan
                            kepemimpinan, serta memperluas wawasan sosial.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('bantuan 1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text">Dapat terlibat aktif dalam menyalurkan bantuan, mendampingi korban, dan
                            memulihkan kondisi lingkungan yang terdampak bencana.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panduan Umum --}}
        <div class="container">
            <h4 class="fw-bold text-center mb-3">Panduan Umum</h4>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tetap Tenang dan Jangan Panik
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Tetap tenang membantu Anda berpikir jernih dan mengambil keputusan yang tepat dalam situasi
                            darurat
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Lindungi Diri (Saat Bencana Sedang Terjadi)
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Cari tempat aman sesuai jenis bencana, seperti berlindung di bawah meja saat gempa atau
                            menjauh dari jendela saat badai.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Ikuti Arahan Resmi
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Dengarkan informasi dari sumber resmi seperti BNPB, BMKG, atau pemerintah setempat untuk
                            tindakan yang benar dan terbaru.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Utamakan Keselamatan Diri dan Keluarga
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Pastikan semua anggota keluarga berada di tempat yang aman sebelum menyelamatkan barang atau
                            membantu orang lain.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Bawa Tas Siaga Darurat
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Siapkan tas berisi kebutuhan penting seperti obat, makanan, air, senter, dan dokumen penting
                            untuk dibawa saat evakuasi.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
