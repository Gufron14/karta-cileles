<div>
    <div class="container-fluid bg-primary p-3">
        <h3 class="text-center fw-bold text-light">Data Pakaian dan Penyaluran</h3>
    </div>

    <div class="container p-5">
        {{-- Pakaian Pakaian Terkumpul --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Data Bantuan Pakaian
                </h5>
            </div>
            <div class="card-body">
                {{-- Search Bar dan Filter menurut Status, Bulan, dan Tahun --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm"
                            placeholder="Cari nama donatur atau jenis pakaian..." wire:model.live="searchPakaian">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" wire:model.live="statusPakaianFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="terverifikasi">Terverifikasi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" wire:model.live="bulanPakaianFilter">
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
                        <select class="form-select form-select-sm" wire:model.live="tahunPakaianFilter">
                            <option value="">Semua Tahun</option>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-sm btn-outline-secondary" wire:click="resetFiltersPakaian">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Donatur</th>
                                <th>Jenis Pakaian</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pakaians as $index => $pakaian)
                                <tr class="text-center">
                                    <td>{{ $pakaians->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pakaian->tanggal)->format('d/m/Y') }}</td>
                                    <td class="text-start">{{ $pakaian->nama_donatur }}</td>
                                    <td>
                                        @if ($pakaian->pakaian_data)
                                            @foreach ($pakaian->pakaian_data as $data)
                                                <small class="badge bg-light text-dark me-1">
                                                    {{ $data['jenis'] }} ({{ $data['ukuran'] }} - {{ $data['jumlah'] }}
                                                    pcs)
                                                </small>
                                            @endforeach
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $pakaian->total_jumlah }} pcs</td>
                                    <td>
                                        @if ($pakaian->status == 'terverifikasi')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
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
                    {{ $pakaians->links() }}
                </div>
            </div>
        </div>

        {{-- Pakaian Disalurkan --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Data Penyaluran Pakaian
                </h5>
            </div>
            <div class="card-body">
                {{-- Search Bar dan Filter menurut Bulan dan tahun --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" wire:model.live="filterStatusPenyaluran">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="disalurkan">Disalurkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" wire:model.live="filterTahunPenyaluran">
                            <option value="">Semua Tahun</option>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-sm btn-outline-secondary" wire:click="resetFiltersPenyaluran">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Pakaian Laki-laki</th>
                                <th>Pakaian Perempuan</th>
                                <th>Pakaian Anak</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penyalurans as $index => $penyaluran)
                                <tr class="text-center">
                                    <td>{{ $penyalurans->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                <td>
                                    @foreach(collect($penyaluran->pakaian_data)->where('jenis', 'laki-laki') as $item)
                                        {{ $item['jumlah'] }} ({{ $item['ukuran'] }}){{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach(collect($penyaluran->pakaian_data)->where('jenis', 'perempuan') as $item)
                                        {{ $item['jumlah'] }} ({{ $item['ukuran'] }}){{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach(collect($penyaluran->pakaian_data)->where('jenis', 'anak') as $item)
                                        {{ $item['jumlah'] }} ({{ $item['ukuran'] }}){{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $penyaluran->total_pakaian }}</td>
                                    <td>
                                        @if ($penyaluran->status == 'disalurkan')
                                            <span class="badge bg-success">Disalurkan</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
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
        </div>
    </div>
</div>
