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
                Data Penyaluran Pakaian
            </h5>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
                wire:click="resetForm">
                <i class="fas fa-plus me-2"></i>Tambah Data
            </button>
        </div>
        <div class="card-body">
            {{-- Search Bar dan Filter menurut Bulan dan tahun --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <select class="form-select form-select-sm" wire:model.live="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="disalurkan">Disalurkan</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
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
                            <th>Pakaian Laki-laki</th>
                            <th>Pakaian Perempuan</th>
                            <th>Pakaian Anak</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyalurans as $index => $penyaluran)
                            <tr class="text-center">
                                <td>{{ $penyalurans->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $penyaluran->p_laki }}</td>
                                <td>{{ $penyaluran->p_perempuan }}</td>
                                <td>{{ $penyaluran->p_anak }}</td>
                                <td>{{ $penyaluran->p_laki + $penyaluran->p_perempuan + $penyaluran->p_anak }}</td>
                                <td>
                                    @if ($penyaluran->status == 'disalurkan')
                                        <span class="badge bg-success">Disalurkan</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        @if ($penyaluran->status == 'pending')                                            
                                            <button class="btn btn-sm btn-success"
                                                wire:click="updateStatus({{ $penyaluran->id }})" title="Ubah Status"
                                                wire:confirm="Apakah Anda yakin ingin mengubah status penyaluran ini?">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-primary" wire:click="edit({{ $penyaluran->id }})"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" wire:click="detail({{ $penyaluran->id }})"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="delete({{ $penyaluran->id }})"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $penyalurans->links() }}
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Data Penyaluran Pakaian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="store">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="p_laki" class="form-label">Pakaian Laki-laki</label>
                                <input type="number" class="form-control @error('p_laki') is-invalid @enderror"
                                    wire:model="p_laki" placeholder="Jumlah pakaian laki-laki" min="0"
                                    value="0">
                                @error('p_laki')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="p_perempuan" class="form-label">Pakaian Perempuan</label>
                                <input type="number" class="form-control @error('p_perempuan') is-invalid @enderror"
                                    wire:model="p_perempuan" placeholder="Jumlah pakaian perempuan" min="0"
                                    value="0">
                                @error('p_perempuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="p_anak" class="form-label">Pakaian Anak</label>
                                <input type="number" class="form-control @error('p_anak') is-invalid @enderror"
                                    wire:model="p_anak" placeholder="Jumlah pakaian anak" min="0"
                                    value="0">
                                @error('p_anak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Penyaluran</label>
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
                                    <option value="disalurkan">Disalurkan</option>
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Penyaluran Pakaian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form wire:submit.prevent="update">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_p_laki" class="form-label">Pakaian Laki-laki</label>
                                <input type="number" class="form-control @error('p_laki') is-invalid @enderror"
                                    wire:model="p_laki" placeholder="Jumlah pakaian laki-laki" min="0">
                                @error('p_laki')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_p_perempuan" class="form-label">Pakaian Perempuan</label>
                                <input type="number" class="form-control @error('p_perempuan') is-invalid @enderror"
                                    wire:model="p_perempuan" placeholder="Jumlah pakaian perempuan" min="0">
                                @error('p_perempuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_p_anak" class="form-label">Pakaian Anak</label>
                                <input type="number" class="form-control @error('p_anak') is-invalid @enderror"
                                    wire:model="p_anak" placeholder="Jumlah pakaian anak" min="0">
                                @error('p_anak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal Penyaluran</label>
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
                                    <option value="disalurkan">Disalurkan</option>
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
                        <h1 class="modal-title fs-5" id="detailModalLabel">Detail Data Penyaluran Pakaian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($detailData)
                            <div class="row">
                                <div class="col-5"><strong>Pakaian Laki-laki:</strong></div>
                                <div class="col-7">{{ $detailData->p_laki }} pcs</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Pakaian Perempuan:</strong></div>
                                <div class="col-7">{{ $detailData->p_perempuan }} pcs</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Pakaian Anak:</strong></div>
                                <div class="col-7">{{ $detailData->p_anak }} pcs</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Total Pakaian:</strong></div>
                                <div class="col-7">
                                    <strong>{{ $detailData->p_laki + $detailData->p_perempuan + $detailData->p_anak }}
                                        pcs</strong></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Tanggal Penyaluran:</strong></div>
                                <div class="col-7">{{ \Carbon\Carbon::parse($detailData->tanggal)->format('d F Y') }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Status:</strong></div>
                                <div class="col-7">
                                    @if ($detailData->status == 'disalurkan')
                                        <span class="badge bg-success">Disalurkan</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Dibuat:</strong></div>
                                <div class="col-7">{{ $detailData->created_at->format('d F Y H:i') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-5"><strong>Diperbarui:</strong></div>
                                <div class="col-7">{{ $detailData->updated_at->format('d F Y H:i') }}</div>
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
