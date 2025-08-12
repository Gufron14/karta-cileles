<div>
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                Edit Data Penyaluran Makanan
            </h5>
            <button class="btn btn-sm btn-secondary" wire:click="cancel">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </button>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Makanan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                wire:model="jumlah" placeholder="Jumlah makanan dalam porsi" min="1">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jml_kk" class="form-label">Jumlah Kepala Keluarga (KK) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jml_kk') is-invalid @enderror"
                                wire:model="jml_kk" placeholder="Jumlah KK yang menerima" min="1">
                            @error('jml_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Penyaluran <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model="alamat"
                        placeholder="Alamat lengkap penyaluran makanan" rows="3"></textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Data Kepala Keluarga <span class="text-danger">*</span></label>
                    <div class="border rounded p-3">
                        @foreach($kk_data as $index => $kk)
                            <div class="row mb-2" wire:key="kk-{{ $index }}">
                                <div class="col-md-5">
                                    <input type="text" class="form-control @error('kk_data.'.$index.'.nama_kk') is-invalid @enderror"
                                        wire:model="kk_data.{{ $index }}.nama_kk" 
                                        placeholder="Nama Kepala Keluarga">
                                    @error('kk_data.'.$index.'.nama_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control @error('kk_data.'.$index.'.nomor_kk') is-invalid @enderror"
                                        wire:model="kk_data.{{ $index }}.nomor_kk" 
                                        placeholder="Nomor KK">
                                    @error('kk_data.'.$index.'.nomor_kk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    @if($index === 0)
                                        <button type="button" class="btn btn-success btn-sm" wire:click="addKK">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="removeKK({{ $index }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        @if(count($kk_data) > 1)
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success btn-sm" wire:click="addKK">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Penyaluran <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                wire:model="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                <option value="pending">Pending</option>
                                <option value="disalurkan">Disalurkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" wire:click="cancel">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>