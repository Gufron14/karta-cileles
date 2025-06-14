<div class="container p-5">
    <div class="card border-0 shadow mb-5">
        <div class="card-body p-5">
            <h4 class="mb-4 fw-bold">Salurkan Donasi untuk Korban Bencana yang terdampak</h4>
            
            <!-- Success Alert -->
            @if($showSuccess)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Terima kasih!</strong> Donasi Anda telah berhasil dikirim dan sedang dalam proses verifikasi.
                <button type="button" class="btn-close" wire:click="hideSuccessAlert"></button>
            </div>
            @endif

            <!-- Error Alert -->
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row mb-4">
                <div class="col">
                    <div class="alert alert-info">Salurkan Donasi Anda melalui:
                        <ul>
                            <li>BNI 0123456789 a.n. Karang Taruna Cileles</li>
                            <li>BRI 0123456789 a.n. Karang Taruna Cileles</li>
                            <li>BCA 0123456789 a.n. Karang Taruna Cileles</li>
                        </ul>
                        <p>Atau melalui QR Code di bawah. Terima kasih atas donasi Anda.</p>
                    </div>
                    <img src="{{ asset('QR.png') }}" alt="qr code" width="80%">
                </div>
                <div class="col">
                    <form wire:submit="submitDonasi">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" pattern="[^0-9]*" title="Tidak boleh ada angka" class="form-control @error('nama_donatur') is-invalid @enderror" 
                                   wire:model.blur="nama_donatur" placeholder="Masukkan nama lengkap">
                            @error('nama_donatur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   wire:model.blur="email" placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('no_hp') is-invalid @enderror" 
                                   wire:model.blur="no_hp" placeholder="08xxxxxxxxxx">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah Nominal Donasi <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" 
                                       wire:model.blur="nominal" placeholder="10000" min="1000">
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Minimal donasi Rp 1.000</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bukti_transfer') is-invalid @enderror" 
                                   wire:model="bukti_transfer" accept="image/*">
                            @error('bukti_transfer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                            
                            <!-- Loading indicator for file upload -->
                            <div wire:loading wire:target="bukti_transfer" class="mt-2">
                                <small class="text-info">
                                    <i class="fas fa-spinner fa-spin"></i> Mengupload file...
                                </small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Catatan untuk kami</label>
                            <textarea rows="2" class="form-control @error('catatan') is-invalid @enderror" 
                                      wire:model.blur="catatan" placeholder="Tulis pesan atau doa untuk korban bencana (opsional)"></textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 500 karakter</small>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold w-100" 
                                wire:loading.attr="disabled" wire:target="submitDonasi">
                            <span wire:loading.remove wire:target="submitDonasi">
                                <i class="fas fa-heart me-2"></i>Kirim Donasi
                            </span>
                            <span wire:loading wire:target="submitDonasi">
                                <i class="fas fa-spinner fa-spin me-2"></i>Mengirim...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('hide-success-alert', () => {
                setTimeout(() => {
                    @this.hideSuccessAlert();
                }, 5000);
            });
        });
    </script>
</div>
