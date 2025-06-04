<div>
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light p-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="fas fa-shield-alt fa-3x text-primary"></i>
                                </div>
                                <h3 class="card-title fw-bold text-dark">Login Admin</h3>
                                <p class="text-muted">Masuk ke panel administrasi</p>
                            </div>
    
                            <!-- Alert Messages -->
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
    
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
    
                            <!-- Login Form -->
                            <form wire:submit="login">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2 text-muted"></i>Email
                                    </label>
                                    <input type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        wire:model="email" placeholder="Masukkan email admin" autocomplete="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
    
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-2 text-muted"></i>Password
                                    </label>
                                    <div class="position-relative">
                                        <input type="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            wire:model="password" placeholder="Masukkan password"
                                            autocomplete="current-password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" wire:model="remember"
                                            id="remember">
                                        <label class="form-check-label text-muted" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                </div>
    
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg fw-semibold"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                                        </span>
                                        <span wire:loading>
                                            <i class="fas fa-spinner fa-spin me-2"></i>Memproses...
                                        </span>
                                    </button>
                                </div>
    
                                {{-- <div class="text-center">
                                    <a href="#" class="text-decoration-none text-muted small">
                                        <i class="fas fa-question-circle me-1"></i>Lupa password?
                                    </a>
                                </div> --}}
                            </form>
                        </div>
    
                        <!-- Footer -->
                        <div class="card-footer bg-light text-center py-3">
                            <small class="text-muted">
                                <i class="fas fa-copyright me-1"></i>
                                {{ date('Y') }} Karta Cileles. All rights reserved.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
