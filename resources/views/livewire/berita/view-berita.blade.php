<div>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bg-light py-3">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('/') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('berita') }}" class="text-decoration-none">Berita</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($berita->judul, 50) }}
                </li>
            </ol>
        </div>
    </nav>

    <!-- Article Content -->
    <article class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Article Header -->
                    <header class="mb-4">
                        @if($berita->bencana)
                            <span class="badge bg-danger fs-6 mb-3">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $berita->bencana->nama }}
                            </span>
                        @endif
                        
                        <h1 class="display-5 fw-bold text-dark mb-3">
                            {{ $berita->judul }}
                        </h1>
                        
                        <div class="d-flex align-items-center text-muted mb-4">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <span class="me-4">{{ $berita->created_at->format('d F Y') }}</span>
                            <i class="fas fa-clock me-2"></i>
                            <span>{{ $berita->created_at->diffForHumans() }}</span>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    @if($berita->thumbnail)
                        <div class="mb-4">
                            <img src="{{ $berita->thumbnail_url }}" 
                                 class="img-fluid rounded shadow-sm w-100" 
                                 alt="{{ $berita->judul }}"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Article Body -->
                    <div class="article-content">
                        {!! $berita->isi !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-top pt-4 mt-5">
                        <h6 class="fw-bold mb-3">Bagikan Artikel:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}" 
                               target="_blank" 
                               class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter me-1"></i>Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->fullUrl()) }}" 
                               target="_blank" 
                               class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp me-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Related News -->
    @if($relatedNews->count() > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h3 class="fw-bold mb-4">Berita Terkait</h3>
                        <div class="row g-4">
                            @foreach($relatedNews as $related)
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm hover-card">
                                        @if($related->thumbnail)
                                            <div class="card-img-wrapper" style="height: 150px; overflow: hidden;">
                                                <img src="{{ $related->thumbnail_url }}" 
                                                     class="card-img-top w-100 h-100" 
                                                     style="object-fit: cover;"
                                                     alt="{{ $related->judul }}">
                                            </div>
                                        @endif
                                        
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="{{ route('detailBerita', $related->slug) }}" 
                                                   class="text-decoration-none text-dark stretched-link">
                                                    {{ Str::limit($related->judul, 50) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                {{ $related->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ route('berita') }}" class="btn btn-primary">
                                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <style>
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        
        .article-content p {
            margin-bottom: 1.5rem;
        }
        
        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }
        
        .article-content blockquote {
            border-left: 4px solid #007bff;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
        }
        
        .hover-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .hover-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1) !important;
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

