<div>

    <div class="container-fluid bg-primary p-3">
        <h3 class="text-center fw-bold text-light">Data Makanan & Penyaluran</h3>
    </div>

    <div class="container p-5">

        {{-- Filter & Table Makanan --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title">Data Bantuan Makanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm"
                            placeholder="Cari nama donatur/jenis makanan..." wire:model.live="search">
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
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                            @endfor
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
                        <button class="btn btn-sm btn-outline-secondary" wire:click="resetFiltersMakanan">
                            Reset Filter
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
                                <th>Jenis Makanan</th>
                                {{-- <th>Jumlah</th> --}}
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($makanans as $index => $makanan)
                                <tr class="text-center">
                                    <td>{{ $makanans->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($makanan->tanggal)->format('d/m/Y') }}</td>
                                    <td class="text-start">{{ $makanan->nama_donatur }}</td>
                                    <td>{{ $makanan->jenis_makanan }}</td>
                                    {{-- <td>{{ $makanan->jumlah_makanan }}</td> --}}
                                    <td>
                                        @if ($makanan->status == 'terverifikasi')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-secondary">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $makanans->links() }}
                </div>
            </div>
        </div>

        {{-- Filter & Table Penyaluran Makanan --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Penyaluran Makanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" wire:model.live="statusPenyaluranFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="disalurkan">Disalurkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" wire:model.live="bulanPenyaluranFilter">
                            <option value="">Semua Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-sm" wire:model.live="tahunPenyaluranFilter">
                            <option value="">Semua Tahun</option>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-sm btn-outline-secondary" wire:click="resetFiltersPenyaluran">
                            Reset Filter
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Alamat</th>
                                {{-- <th>Jumlah Makanan</th> --}}
                                <th>Jumlah KK</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penyalurans as $index => $penyaluran)
                                <tr class="text-center">
                                    <td>{{ $penyalurans->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penyaluran->tanggal)->format('d/m/Y') }}</td>
                                    <td class="text-start">{{ $penyaluran->alamat }}</td>
                                    {{-- <td>{{ $penyaluran->jumlah }}</td> --}}
                                    <td>{{ $penyaluran->jml_kk }}</td>
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
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $penyalurans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
