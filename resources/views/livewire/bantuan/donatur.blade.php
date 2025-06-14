<div>

    <div class="container-fluid bg-primary p-3">
        <h3 class="text-center fw-bold text-light">Data Donasi dan Penyaluran</h3>
    </div>

    <div class="container p-5">

        <!-- Data Donasi Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Kolaborasi/Bantuan Donasi</h5>
                <a href="{{ route('donasi') }}" class="btn btn-primary fw-bold">Kirim Donasi</a>
            </div>
            <div class="card-body p-3">
                <!-- Filter Donasi -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Cari nama kamu"
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
                            <option value="pending">Menunggu</option>
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
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Nama Donatur</th>
                                {{-- <th>Email</th>
                            <th>No. HP</th> --}}
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donasis as $index => $donasi)
                                <tr>
                                    <td class="text-center">{{ $donasis->firstItem() + $index }}</td>
                                    <td class="text-center">
                                        {{ $donasi->created_at ? $donasi->created_at->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $donasi->nama_donatur }}</td>
                                    {{-- <td class="text-start">{{ $donasi->email }}</td>
                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $donasi->no_hp) }}"
                                        target="_blank">{{ $donasi->no_hp }}</a>
                                </td> --}}
                                    <td>{{ $donasi->nominal_formatted }}</td>
                                    <td class="text-center">
                                        @if ($donasi->status == 'terverifikasi')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
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
            <div class="card-header">
                <h5 class="card-title mb-0">Data Bantuan Tersalurkan</h5>
            </div>
            <div class="card-body p-3">
                <!-- Filter Penyaluran -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm"
                            placeholder="Cari alamat/keterangan..." wire:model.live="searchPenyaluran">
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
                            <option value="pending">Menunggu</option>
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
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Uang Keluar</th>
                                <th>Alamat Penyaluran</th>
                                <th>Jml. KK</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penyalurans as $index => $penyaluran)
                                <tr>
                                    <td class="text-center">{{ $penyalurans->firstItem() + $index }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $penyaluran->uang_keluar_formatted }}</td>
                                    <td>{{ Str::limit($penyaluran->alamat, 30) }}</td>
                                    <td class="text-center">{{ $penyaluran->jml_kpl_keluarga }} KK</td>
                                    <td class="text-center">
                                        @if ($penyaluran->status == 'terverifikasi')
                                            <span class="badge bg-success">Disalurkan</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
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

    </div>
</div>
