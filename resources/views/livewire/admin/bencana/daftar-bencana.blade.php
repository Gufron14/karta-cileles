<div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                Daftar Bencana
            </h5>
            <button class="btn btn-sm btn-primary" wire:click="openModal">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </button>
        </div>
        <div class="card-body">
            {{-- Search Bar dan Filter --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm"
                        placeholder="Cari nama bencana atau lokasi..." wire:model.live="search">
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" wire:model.live="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm" wire:model.live="filterTahun">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunOptions as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Jenis Bencana</th>
                            <th>Lokasi</th>
                            <th>Tanggal Kejadian</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bencanas as $index => $bencana)
                            <tr class="text-center">
                                <td>{{ $bencanas->firstItem() + $index }}</td>
                                <td>{{ $bencana->nama_bencana }}</td>
                                <td>{{ $bencana->lokasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($bencana->tanggal_kejadian)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($bencana->status === 'aktif')
                                        <span class="badge bg-danger">Aktif</span>
                                    @else
                                        <span class="badge bg-warning">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($bencana->deskripsi, 50) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-info"
                                            wire:click="toggleStatus({{ $bencana->id }})" title="Ubah Status">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary"
                                            wire:click="showDetail({{ $bencana->id }})" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning"
                                            wire:click="edit({{ $bencana->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $bencana->id }})"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data bencana</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $bencanas->links() }}
        </div>
    </div>

    {{-- Modal Tambah/Edit Data Bencana --}}
    @if ($showModal)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editMode ? 'Edit' : 'Tambah' }} Data Bencana</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Bencana <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nama_bencana') is-invalid @enderror"
                                            wire:model="nama_bencana" placeholder="Contoh: Banjir, Gempa Bumi, dll">
                                        @error('nama_bencana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                            wire:model="lokasi" placeholder="Contoh: Desa Cileles, Kec. XXX">
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Kejadian <span
                                                class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                            wire:model="tanggal_kejadian">
                                        @error('tanggal_kejadian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror"
                                            wire:model="status">
                                            <option value="aktif">Aktif</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" wire:model="deskripsi" rows="3"
                                    placeholder="Deskripsi detail tentang bencana..."></textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Dokumentasi (Foto/Video)</label>
                                <div id="file-upload-container">
                                    <div class="file-upload-item mb-2">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <input type="file"
                                                    class="form-control @error('files.0') is-invalid @enderror"
                                                    wire:model="files.0" accept="image/*,video/*">
                                                @error('files.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control"
                                                    wire:model="keterangan_files.0" placeholder="Keterangan file">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                    onclick="addFileInput()">
                                    <i class="fas fa-plus"></i> Tambah File
                                </button>
                                <small class="form-text text-muted">
                                    Format yang didukung: JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV. Maksimal 50MB per
                                    file.
                                </small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    wire:click="closeModal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <span wire:loading.remove>{{ $editMode ? 'Update' : 'Simpan' }}</span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i> Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

    {{-- Modal Detail Bencana --}}
    @if ($showDetailModal && $selectedBencana)
        <div class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Bencana: {{ $selectedBencana->nama_bencana }}</h5>
                        <button type="button" class="btn-close" wire:click="closeDetailModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nama Bencana:</strong></td>
                                        <td>{{ $selectedBencana->nama_bencana }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Lokasi:</strong></td>
                                        <td>{{ $selectedBencana->lokasi }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Kejadian:</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($selectedBencana->tanggal_kejadian)->format('d F Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if ($selectedBencana->status === 'aktif')
                                                <span class="badge bg-danger">Aktif</span>
                                            @else
                                                <span class="badge bg-warning">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Deskripsi:</strong></td>
                                        <td>{{ $selectedBencana->deskripsi ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Dokumentasi ({{ $selectedBencana->dokumentasi->count() }} file)</strong>
                                </h6>
                                @if ($selectedBencana->dokumentasi->count() > 0)
                                    <div class="row">
                                        @foreach ($selectedBencana->dokumentasi as $dok)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        @if ($dok->jenis_media === 'foto')
                                                            <img src="{{ Storage::url($dok->file_path) }}"
                                                                class="img-fluid rounded mb-2"
                                                                style="max-height: 150px; width: 100%; object-fit: cover;">
                                                        @else
                                                            <video controls class="w-100 rounded mb-2"
                                                                style="max-height: 150px;">
                                                                <source src="{{ Storage::url($dok->file_path) }}"
                                                                    type="video/mp4">
                                                                Browser Anda tidak mendukung video.
                                                            </video>
                                                        @endif

                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <small class="text-muted d-block">
                                                                    <i
                                                                        class="fas fa-{{ $dok->jenis_media === 'foto' ? 'image' : 'video' }}"></i>
                                                                    {{ ucfirst($dok->jenis_media) }}
                                                                </small>
                                                                @if ($dok->keterangan)
                                                                    <small
                                                                        class="text-dark">{{ $dok->keterangan }}</small>
                                                                @endif
                                                            </div>
                                                            <button class="btn btn-sm btn-outline-danger"
                                                                wire:click="deleteFile({{ $dok->id }})"
                                                                onclick="return confirm('Yakin ingin menghapus file ini?')"
                                                                title="Hapus File">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Belum ada dokumentasi</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDetailModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif

</div>
    <script>
        let fileInputCount = 1;

        function addFileInput() {
            const container = document.getElementById('file-upload-container');
            const newFileInput = document.createElement('div');
            newFileInput.className = 'file-upload-item mb-2';
            newFileInput.innerHTML = `
                <div class="row">
                    <div class="col-md-8">
                        <input type="file" class="form-control" 
                               wire:model="files.${fileInputCount}" accept="image/*,video/*">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" 
                               wire:model="keterangan_files.${fileInputCount}" 
                               placeholder="Keterangan file">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFileInput(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newFileInput);
            fileInputCount++;
        }

        function removeFileInput(button) {
            button.closest('.file-upload-item').remove();
        }
    </script>
