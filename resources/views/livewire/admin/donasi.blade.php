<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Data Donasi Card -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Kolaborasi/Bantuan Donasi</h5>
            <button class="btn btn-sm btn-primary" wire:click="openModalDonasi">
                <i class="fas fa-plus me-1"></i>Tambah Data
            </button>
        </div>
        <div class="card-body p-3">
            <!-- Filter Donasi -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari nama/email..."
                        wire:model.live="searchDonasi">
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterBulanDonasi">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterTahunDonasi">
                        <option value="">Semua Tahun</option>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterStatusDonasi">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="terverifikasi">Terverifikasi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary btn-sm" wire:click="resetFilterDonasi">
                        <i class="fas fa-refresh me-1"></i>Reset Filter
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Donatur</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donasis as $index => $donasi)
                            <tr class="text-center">
                                <td>{{ $donasis->firstItem() + $index }}</td>
                                <td>{{ $donasi->created_at ? $donasi->created_at->format('d/m/Y') : '-' }}</td>
                                <td class="text-start">{{ $donasi->nama_donatur }}</td>
                                <td>{{ $donasi->email }}</td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $donasi->no_hp) }}"
                                        target="_blank">{{ $donasi->no_hp }}</a>
                                </td>
                                <td>{{ $donasi->nominal_formatted }}</td>
                                <td>
                                    @if ($donasi->status == 'terverifikasi')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if ($donasi->status == 'pending')
                                            <button class="btn btn-success btn-sm"
                                                wire:click="verifikasiDonasi({{ $donasi->id }})"
                                                wire:confirm="Yakin ingin memverifikasi donasi ini?">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="openModalDonasi({{ $donasi->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            wire:click="deleteDonasi({{ $donasi->id }})"
                                            wire:confirm="Yakin ingin menghapus data ini?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button class="btn btn-info btn-sm"
                                            wire:click="showDetailDonasi({{ $donasi->id }})" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data donasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Donasi -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $donasis->firstItem() ?? 0 }} - {{ $donasis->lastItem() ?? 0 }}
                        dari {{ $donasis->total() }} data
                    </small>
                </div>
                <div>
                    {{ $donasis->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Data Penyaluran Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Data Bantuan Tersalurkan</h5>
            <button class="btn btn-sm btn-primary" wire:click="openModalPenyaluran">
                <i class="fas fa-plus me-1"></i>Tambah Data
            </button>
        </div>
        <div class="card-body p-3">
            <!-- Filter Penyaluran -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari alamat/keterangan..."
                        wire:model.live="searchPenyaluran">
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterBulanPenyaluran">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterTahunPenyaluran">
                        <option value="">Semua Tahun</option>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="filterStatusPenyaluran">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="terverifikasi">Terverifikasi</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary btn-sm" wire:click="resetFilterPenyaluran">
                        <i class="fas fa-refresh me-1"></i>Reset Filter
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Uang Keluar</th>
                            <th>Alamat Penyaluran</th>
                            <th>Jml. KK</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyalurans as $index => $penyaluran)
                            <tr class="text-center">
                                <td>{{ $penyalurans->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $penyaluran->uang_keluar_formatted }}</td>
                                <td>{{ Str::limit($penyaluran->alamat, 30) }}</td>
                                <td>{{ $penyaluran->jml_kpl_keluarga }} KK</td>
                                <td>
                                    @if ($penyaluran->status == 'terverifikasi')
                                        <span class="badge bg-success">Disalurkan</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if ($penyaluran->status == 'pending')
                                            <button class="btn btn-success btn-sm"
                                                wire:click="verifikasiPenyaluran({{ $penyaluran->id }})"
                                                wire:confirm="Yakin ingin memverifikasi penyaluran ini?">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="openModalPenyaluran({{ $penyaluran->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                            wire:click="deletePenyaluran({{ $penyaluran->id }})"
                                            wire:confirm="Yakin ingin menghapus data ini?">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data penyaluran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Penyaluran -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan {{ $penyalurans->firstItem() ?? 0 }} - {{ $penyalurans->lastItem() ?? 0 }}
                        dari {{ $penyalurans->total() }} data
                    </small>
                </div>
                <div>
                    {{ $penyalurans->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Donasi -->
    @if ($showModalDonasi)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $donasiId ? 'Edit' : 'Tambah' }} Data Donasi</h5>
                        <button type="button" class="btn-close" wire:click="closeModalDonasi"></button>
                    </div>
                    <form wire:submit="savedonasi">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Donatur <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('nama_donatur') is-invalid @enderror"
                                            wire:model="nama_donatur" placeholder="Nama lengkap donatur">
                                        @error('nama_donatur')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            wire:model="email" placeholder="email@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">No. HP <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('no_hp') is-invalid @enderror"
                                            wire:model="no_hp" placeholder="08xxxxxxxxxx">
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nominal <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number"
                                                class="form-control @error('nominal') is-invalid @enderror"
                                                wire:model="nominal" placeholder="10000" min="1000">
                                        </div>
                                        @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bukti Transfer {{ !$donasiId ? '*' : '' }}</label>
                                        <input type="file"
                                            class="form-control @error('bukti_transfer') is-invalid @enderror"
                                            wire:model="bukti_transfer" accept="image/*">
                                        @error('bukti_transfer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: JPG, PNG, JPEG. Max 2MB</small>

                                        <div wire:loading wire:target="bukti_transfer" class="mt-2">
                                            <small class="text-info">
                                                <i class="fas fa-spinner fa-spin"></i> Mengupload file...
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status_donasi') is-invalid @enderror"
                                            wire:model="status_donasi">
                                            <option value="pending">Pending</option>
                                            <option value="terverifikasi">Terverifikasi</option>
                                        </select>
                                        @error('status_donasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" wire:model="catatan" rows="3"
                                    placeholder="Catatan dari donatur"></textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeModalDonasi">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="savedonasi">
                                    <i class="fas fa-save me-1"></i>{{ $donasiId ? 'Update' : 'Simpan' }}
                                </span>
                                <span wire:loading wire:target="savedonasi">
                                    <i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Tambah/Edit Penyaluran -->
    @if ($showModalPenyaluran)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $penyaluranId ? 'Edit' : 'Tambah' }} Data Penyaluran</h5>
                        <button type="button" class="btn-close" wire:click="closeModalPenyaluran"></button>
                    </div>
                    <form wire:submit="savePenyaluran">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('tanggal') is-invalid @enderror"
                                            wire:model="tanggal">
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Uang Keluar <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number"
                                                class="form-control @error('uang_keluar') is-invalid @enderror"
                                                wire:model="uang_keluar" placeholder="50000" min="1000">
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
                                        <input type="text"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            wire:model="alamat" placeholder="Alamat lengkap penerima bantuan">
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah KK <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('jml_kpl_keluarga') is-invalid @enderror"
                                            wire:model="jml_kpl_keluarga" placeholder="5" min="1">
                                        @error('jml_kpl_keluarga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status_penyaluran') is-invalid @enderror"
                                            wire:model="status_penyaluran">
                                            <option value="pending">Pending</option>
                                            <option value="terverifikasi">Disalurkan</option>
                                        </select>
                                        @error('status_penyaluran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" wire:model="keterangan" rows="3"
                                    placeholder="Keterangan tambahan (opsional)"></textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                wire:click="closeModalPenyaluran">Batal</button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="savePenyaluran">
                                    <i class="fas fa-save me-1"></i>{{ $penyaluranId ? 'Update' : 'Simpan' }}
                                </span>
                                <span wire:loading wire:target="savePenyaluran">
                                    <i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal Detail Bukti Transfer dan Catatan Donatur -->
    @if ($showModalDetail)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Donasi - {{ $detailDonasi->nama_donatur ?? '' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModalDetail"></button>
                    </div>
                    <div class="modal-body">
                        @if ($detailDonasi)
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Bukti Transfer</h6>
                                    @if ($detailDonasi->bukti_transfer)
                                        <img src="{{ Storage::url($detailDonasi->bukti_transfer) }}"
                                            class="img-fluid rounded border" alt="Bukti Transfer"
                                            style="max-height: 400px; width: 100%; object-fit: contain;">
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Bukti transfer tidak tersedia
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Informasi Donasi</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-semibold">Nama Donatur:</td>
                                            <td>{{ $detailDonasi->nama_donatur }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Email:</td>
                                            <td>{{ $detailDonasi->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">No. HP:</td>
                                            <td>
                                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $detailDonasi->no_hp) }}"
                                                    target="_blank" class="text-decoration-none">
                                                    {{ $detailDonasi->no_hp }}
                                                    <i class="fab fa-whatsapp text-success ms-1"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Nominal:</td>
                                            <td class="fw-bold text-success">{{ $detailDonasi->nominal_formatted }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Status:</td>
                                            <td>
                                                @if ($detailDonasi->status == 'terverifikasi')
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Tanggal:</td>
                                            <td>{{ $detailDonasi->created_at ? $detailDonasi->created_at->format('d/m/Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                    </table>

                                    <h6 class="fw-bold mb-2 mt-4">Catatan dari Donatur</h6>
                                    @if ($detailDonasi->catatan)
                                        <div class="alert alert-light border">
                                            <i class="fas fa-quote-left text-muted me-2"></i>
                                            {{ $detailDonasi->catatan }}
                                            <i class="fas fa-quote-right text-muted ms-2"></i>
                                        </div>
                                    @else
                                        <div class="text-muted fst-italic">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Tidak ada catatan dari donatur
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModalDetail">Tutup</button>
                        @if ($detailDonasi && $detailDonasi->bukti_transfer)
                            <a href="{{ Storage::url($detailDonasi->bukti_transfer) }}" target="_blank"
                                class="btn btn-primary">
                                <i class="fas fa-download me-1"></i>Download Bukti
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
