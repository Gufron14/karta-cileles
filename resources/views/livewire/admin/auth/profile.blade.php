<div class="container">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row gap-4">
        <!-- Profile Information Card -->
        <div class="col card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Informasi Profil
                </h5>
            </div>
            <div class="card-body">
                <form wire:submit="updateProfile">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model="email" placeholder="Masukkan email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Settings Card -->
        <div class="col card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan
                </h5>
            </div>
            <div class="card-body">
                @if (!$showChangePassword)
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Password</h6>
                            <small class="text-muted">Terakhir diubah:
                                {{ Auth::user()->updated_at->format('d M Y') }}</small>
                        </div>
                        <button type="button" class="btn btn-outline-primary" wire:click="toggleChangePassword">
                            <i class="fas fa-key me-2"></i>Ubah Password
                        </button>
                    </div>
                @else
                    <form wire:submit="changePassword">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                wire:model="current_password" placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                wire:model="new_password" placeholder="Masukkan password baru">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                    class="text-danger">*</span></label>
                            <input type="password"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                wire:model="new_password_confirmation" placeholder="Konfirmasi password baru">
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Password
                            </button>
                            <button type="button" class="btn btn-secondary" wire:click="toggleChangePassword">
                                <i class="fas fa-times me-2"></i>Batal
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
