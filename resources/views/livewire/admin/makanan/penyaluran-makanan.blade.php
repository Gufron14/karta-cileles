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
                Data Penyaluran Makanan
            </h5>
            <button class="btn btn-sm btn-primary" wire:click="create">
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
                            <th>Alamat</th>
                            <th>Jumlah KK</th>
                            <th>Data Kepala Keluarga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyalurans as $index => $penyaluran)
                            <tr class="text-center">
                                <td>{{ $penyalurans->firstItem() + $index }}</td>
                                <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                <td class="text-start">{{ $penyaluran->alamat }}</td>
                                <td>{{ number_format($penyaluran->jml_kk) }} KK</td>
                                <td class="text-start">
                                    @if($penyaluran->nama_kk && $penyaluran->nomor_kk)
                                        @php
                                            // Handle both JSON and old string format for nama_kk
                                            $nama_kk_decoded = json_decode($penyaluran->nama_kk, true);
                                            if (is_array($nama_kk_decoded)) {
                                                $nama_kk_array = $nama_kk_decoded;
                                            } else {
                                                // Old format: comma-separated string
                                                $nama_kk_array = array_map('trim', explode(',', $penyaluran->nama_kk));
                                            }
                                            
                                            // Handle nomor_kk (should be JSON format)
                                            $nomor_kk_array = json_decode($penyaluran->nomor_kk, true) ?: [];
                                        @endphp
                                        @for($i = 0; $i < max(count($nama_kk_array), count($nomor_kk_array)); $i++)
                                            <div class="mb-1">
                                                <strong>{{ $nama_kk_array[$i] ?? '-' }}</strong><br>
                                                <small class="text-muted">KK: {{ $nomor_kk_array[$i] ?? '-' }}</small>
                                            </div>
                                        @endfor
                                    @elseif($penyaluran->nama_kk)
                                        @php
                                            // Handle both JSON and old string format for nama_kk
                                            $nama_kk_decoded = json_decode($penyaluran->nama_kk, true);
                                            if (is_array($nama_kk_decoded)) {
                                                $nama_kk_array = $nama_kk_decoded;
                                            } else {
                                                // Old format: comma-separated string
                                                $nama_kk_array = array_map('trim', explode(',', $penyaluran->nama_kk));
                                            }
                                        @endphp
                                        @foreach($nama_kk_array as $nama)
                                            <div class="mb-1">{{ $nama }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada data</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    @if ($penyaluran->status == 'disalurkan')
                                        <span class="badge bg-success">Disalurkan</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if ($penyaluran->status == 'pending')                                            
                                        <button class="btn btn-sm btn-success"
                                            wire:click="updateStatus({{ $penyaluran->id }})" title="Ubah Status"
                                            wire:confirm="Apakah Anda yakin ingin memverifikasi data ini?">
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
                                <td colspan="7" class="text-center">Tidak ada data</td>
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

        {{-- Modal Detail --}}
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
            aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="detailModalLabel">Detail Data Penyaluran Makanan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($detailData)
                            <div class="row">
                                <div class="col-5"><strong>Jumlah Makanan:</strong></div>
                                <div class="col-7">{{ number_format($detailData->jumlah) }} porsi</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Alamat Penyaluran:</strong></div>
                                <div class="col-7">{{ $detailData->alamat }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Jumlah KK:</strong></div>
                                <div class="col-7">{{ number_format($detailData->jml_kk) }} KK</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Rata-rata per KK:</strong></div>
                                <div class="col-7">
                                    <strong>{{ number_format($detailData->jumlah / $detailData->jml_kk, 1) }}
                                        porsi/KK</strong>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-5"><strong>Data KK:</strong></div>
                                <div class="col-7">
                                    @if($detailData->nama_kk && $detailData->nomor_kk)
                                        @php
                                            // Handle both JSON and old string format for nama_kk
                                            $nama_kk_decoded = json_decode($detailData->nama_kk, true);
                                            if (is_array($nama_kk_decoded)) {
                                                $nama_kk_array = $nama_kk_decoded;
                                            } else {
                                                // Old format: comma-separated string
                                                $nama_kk_array = array_map('trim', explode(',', $detailData->nama_kk));
                                            }
                                            
                                            // Handle nomor_kk (should be JSON format)
                                            $nomor_kk_array = json_decode($detailData->nomor_kk, true) ?: [];
                                        @endphp
                                        @for($i = 0; $i < max(count($nama_kk_array), count($nomor_kk_array)); $i++)
                                            <div class="mb-2">
                                                <span class="badge bg-info me-1">{{ $nama_kk_array[$i] ?? '-' }}</span>
                                                <br><small class="text-muted">KK: {{ $nomor_kk_array[$i] ?? '-' }}</small>
                                            </div>
                                        @endfor
                                    @elseif($detailData->nama_kk)
                                        @php
                                            // Handle both JSON and old string format for nama_kk
                                            $nama_kk_decoded = json_decode($detailData->nama_kk, true);
                                            if (is_array($nama_kk_decoded)) {
                                                $nama_kk_array = $nama_kk_decoded;
                                            } else {
                                                // Old format: comma-separated string
                                                $nama_kk_array = array_map('trim', explode(',', $detailData->nama_kk));
                                            }
                                        @endphp
                                        @foreach($nama_kk_array as $nama)
                                            <span class="badge bg-info me-1 mb-1">{{ $nama }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada data</span>
                                    @endif
                                </div>
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