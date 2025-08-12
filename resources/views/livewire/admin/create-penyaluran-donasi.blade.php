<div>
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                Tambah Penyaluran Donasi
            </h5>
            <a href="{{ route('data-donasi') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" wire:model="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Uang Keluar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('uang_keluar') is-invalid @enderror" wire:model="uang_keluar" min="1000">
                            </div>
                            @error('uang_keluar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" wire:model="alamat" placeholder="Alamat lengkap">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Jumlah KK <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jml_kpl_keluarga') is-invalid @enderror" wire:model.live="jml_kpl_keluarga" min="1">
                            @error('jml_kpl_keluarga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Field nama & nomor KK akan mengikuti jumlah KK</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data Kepala Keluarga <span class="text-danger">*</span></label>
                    <div class="border rounded p-3">
                        @foreach($kk_data as $index => $kk)
                            <div class="row g-2 align-items-center mb-2" wire:key="kk-{{ $index }}">
                                <div class="col-md-1 text-center">
                                    <strong>{{ $index + 1 }}.</strong>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control @error('kk_data.'.$index.'.nama_kk') is-invalid @enderror" placeholder="Nama KK" wire:model="kk_data.{{ $index }}.nama_kk">
                                    @error('kk_data.'.$index.'.nama_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control @error('kk_data.'.$index.'.nomor_kk') is-invalid @enderror" placeholder="Nomor KK" wire:model="kk_data.{{ $index }}.nomor_kk">
                                    @error('kk_data.'.$index.'.nomor_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm" wire:click="addKK"><i class="fas fa-plus"></i></button>
                                        @if(count($kk_data) > 1)
                                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeKK({{ $index }})"><i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_penyaluran') is-invalid @enderror" wire:model="status_penyaluran">
                                <option value="pending">Pending</option>
                                <option value="terverifikasi">Disalurkan</option>
                            </select>
                            @error('status_penyaluran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="3" wire:model="keterangan" placeholder="Keterangan tambahan (opsional)"></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('data-donasi') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>