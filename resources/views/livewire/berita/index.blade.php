<div>
    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class=" fw-bold mb-2">Berita Terkini</h2>
                    <p class="lead mb-0">Informasi terbaru seputar kegiatan Karang Taruna Cileles dan berita bencana terkini</p>
                </div>
                <div class="col-lg-4">
                    <div class="text-lg-end">
                        <i class="fas fa-newspaper fa-5x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control form-control-lg" 
                               placeholder="Cari berita..." 
                               wire:model.live.debounce.300ms="search">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Content -->
    <section class="py-5">
        <div class="container">
            @if($beritas->count() > 0)
                <div class="row g-4">
                    @foreach($beritas as $berita)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-card">
                                @if($berita->thumbnail)
                                    <div class="card-img-wrapper" style="height: 200px; overflow: hidden;">
                                        <img src="{{ $berita->thumbnail_url }}" 
                                             class="card-img-top w-100 h-100" 
                                             style="object-fit: cover;"
                                             alt="{{ $berita->judul }}">
                                    </div>
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    @if($berita->bencana)
                                        <span class="badge bg-danger mb-2 align-self-start">
                                            {{ $berita->bencana->nama_bencana }}
                                        </span>
                                    @endif
                                    
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('detailBerita', $berita->slug) }}" 
                                           class="text-decoration-none text-dark stretched-link">
                                            {{ Str::limit($berita->judul, 60) }}
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit(strip_tags($berita->isi), 100) }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $berita->created_at->format('d M Y') }}
                                        </small>
                                        <small class="text-primary fw-semibold">
                                            Baca Selengkapnya
                                            <i class="fas fa-arrow-right ms-1"></i>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($beritas->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $beritas->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Tidak Ada Berita Ditemukan</h3>
                    @if($search)
                        <p class="text-muted mb-3">
                            Tidak ada hasil untuk pencarian "<strong>{{ $search }}</strong>"
                        </p>
                        <button class="btn btn-outline-primary" wire:click="$set('search', '')">
                            <i class="fas fa-times me-2"></i>Hapus Pencarian
                        </button>
                    @else
                        <p class="text-muted">Belum ada berita yang dipublikasikan</p>
                    @endif
                </div>
            @endif
        </div>
    </section>

    <style>
        .hover-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .card-img-wrapper {
            position: relative;
            overflow: hidden;
        }
        
        .card-img-wrapper img {
            transition: transform 0.3s ease;
        }
        
        .hover-card:hover .card-img-wrapper img {
            transform: scale(1.05);
        }
    </style>
</div>
