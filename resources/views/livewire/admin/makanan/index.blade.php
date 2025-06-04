<div>
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Index Makanan --}}
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                Data Bantuan Makanan
            </h5>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
                wire:click="resetForm">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </button>
        </div>
        <div class="card-body">
            {{-- Search Bar dan Filter menurut Status, Bulan, dan Tahun --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm"
                        placeholder="Cari nama donatur atau jenis makanan..." wire:model.live="search">
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="terverifikasi">Terverifikasi</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select form-select-sm" wire:model.live="bulanFilter">
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
                    <select class="form-select form-select-sm" wire:model.live="tahunFilter">
                        <option value="">Semua Tahun</option>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-sm btn-secondary" wire:click="resetFilters">
                        <i class="fas fa-refresh me-1"></i>Reset Filter
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Donatur</th>
                            <th>Jenis Makanan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($makanans as $index => $makanan)
                            <tr class="text-center">
                                <td>{{ $makanans->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($makanan->tanggal)->format('d/m/Y') }}</td>
                                <td class="text-start">{{ $makanan->nama_donatur }}</td>
                                <td class="text-start">{{ $makanan->jenis_makanan }}</td>
                                <td class="text-end">
                                    @if ($makanan->jumlah_makanan)
                                        {{ number_format($makanan->jumlah_makanan) }} porsi
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($makanan->status == 'terverifikasi')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @if ($makanan->status == 'pending')
                                            <button class="btn btn-sm btn-success"
                                                wire:click="verifikasi({{ $makanan->id }})" title="Verifikasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-warning" wire:click="edit({{ $makanan->id }})"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" wire:click="detail({{ $makanan->id }})"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $makanan->id }})"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $makanans->links() }}
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Data Makanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="jenis_makanan" class="form-label">Jenis Makanan</label>
                                <input type="text"
                                    class="form-control @error('jenis_makanan') is-invalid @enderror"
                                    wire:model="jenis_makanan" placeholder="Contoh: Nasi Bungkus, Roti, Mie Instan">
                                @error('jenis_makanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_makanan" class="form-label">Jumlah Makanan (Opsional)</label>
                                <input type="number"
                                    class="form-control @error('jumlah_makanan') is-invalid @enderror"
                                    wire:model="jumlah_makanan" placeholder="Masukkan jumlah makanan (porsi)"
                                    min="1">
                                @error('jumlah_makanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan jika jumlah tidak diketahui</div>
                            </div>
                            <div class="mb-3">
                                <label for="nama_donatur" class="form-label">Nama Donatur</label>
                                <input type="text" class="form-control @error('nama_donatur') is-invalid @enderror"
                                    wire:model="nama_donatur" placeholder="Masukkan nama donatur">
                                @error('nama_donatur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    wire:model="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                    <option value="pending">Pending</option>
                                    <option value="terverifikasi">Terverifikasi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Makanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_jenis_makanan" class="form-label">Jenis Makanan</label>
                                <input type="text"
                                    class="form-control @error('jenis_makanan') is-invalid @enderror"
                                    wire:model="jenis_makanan" placeholder="Contoh: Nasi Bungkus, Roti, Mie Instan">
                                @error('jenis_makanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_jumlah_makanan" class="form-label">Jumlah Makanan (Opsional)</label>
                                <input type="number"
                                    class="form-control @error('jumlah_makanan') is-invalid @enderror"
                                    wire:model="jumlah_makanan" placeholder="Masukkan jumlah makanan (porsi)"
                                    min="1">
                                @error('jumlah_makanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan jika jumlah tidak diketahui</div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama_donatur" class="form-label">Nama Donatur</label>
                                <input type="text" class="form-control @error('nama_donatur') is-invalid @enderror"
                                    wire:model="nama_donatur" placeholder="Masukkan nama donatur">
                                @error('nama_donatur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    wire:model="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                    <option value="pending">Pending</option>
                                    <option value="terverifikasi">Terverifikasi</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Detail --}}
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailModalLabel">Detail Data Makanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($detailData)
                            <div class="row">
                                <div class="col-4"><strong>Jenis Makanan:</strong></div>
                                <div class="col-8">{{ $detailData->jenis_makanan }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4"><strong>Jumlah:</strong></div>
                                <div class="col-8">
                                    @if ($detailData->jumlah_makanan)
                                        {{ number_format($detailData->jumlah_makanan) }} porsi
                                    @else
                                        <span class="text-muted">Tidak diketahui</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4"><strong>Nama Donatur:</strong></div>
                                <div class="col-8">{{ $detailData->nama_donatur }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4"><strong>Tanggal:</strong></div>
                                <div class="col-8">{{ \Carbon\Carbon::parse($detailData->tanggal)->format('d F Y') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4"><strong>Status:</strong></div>
                                <div class="col-8">
                                    @if ($detailData->status == 'terverifikasi')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-4"><strong>Dibuat:</strong></div>
                                <div class="col-8">{{ $detailData->created_at->format('d F Y H:i') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-4"><strong>Diperbarui:</strong></div>
                                <div class="col-8">{{ $detailData->updated_at->format('d F Y H:i') }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript untuk handle modal --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal', (modalId) => {
                const modal = new bootstrap.Modal(document.getElementById(modalId));
                modal.show();
            });

            Livewire.on('close-modal', (modalId) => {
                const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
</div>
