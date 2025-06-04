<div>
    <!-- FAQ Header -->
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Frequently Asked Questions</h1>
                    <p class="lead">Temukan jawaban atas pertanyaan yang sering diajukan seputar Karang Taruna Cileles</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="input-group input-group-lg">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Cari pertanyaan..." 
                               wire:model.live.debounce.300ms="search">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if($faqs->count() > 0)
                        <div class="accordion" id="faqAccordion">
                            @foreach($faqs as $index => $faq)
                                <div class="accordion-item mb-3 border rounded shadow-sm">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button collapsed fw-semibold" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse{{ $index }}" 
                                                aria-expanded="false" 
                                                aria-controls="collapse{{ $index }}">
                                            <i class="fas fa-question-circle text-primary me-2"></i>
                                            {{ $faq->pertanyaan }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" 
                                         class="accordion-collapse collapse" 
                                         aria-labelledby="heading{{ $index }}" 
                                         data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex">
                                                <i class="fas fa-comment-dots text-success me-2 mt-1"></i>
                                                <p class="mb-0">{{ $faq->jawaban }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak ada FAQ yang ditemukan</h4>
                            <p class="text-muted">Coba gunakan kata kunci yang berbeda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h3 class="fw-bold mb-3">Tidak menemukan jawaban yang Anda cari?</h3>
                    <p class="text-muted mb-4">Hubungi kami langsung untuk mendapatkan bantuan lebih lanjut</p>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-phone fa-2x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Telepon</h6>
                                    <p class="text-muted small mb-0">+62 123 456 789</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Email</h6>
                                    <p class="text-muted small mb-0">info@kartacileles.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
                                    <h6 class="fw-bold">Alamat</h6>
                                    <p class="text-muted small mb-0">Desa Cileles, Kec. Jatinangor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
