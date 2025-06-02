<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Data Relawan</h4>
            {{-- Tambah Relawan --}}
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#relawanModal"
                wire:click='openModal'><i class="fas fa-plus me-1"></i>Tambah Relawan</button>
        </div>
        <div class="card-body p-3">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search Bar dan Filter -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Cari nama/email..."
                        wire:model.live="search">
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live="filterJenisKelamin">
                        <option value="">Semua Jenis Kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pasif">Pasif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filterAlamat">
                        <option value="">Semua Alamat</option>
                        @foreach ($alamatOptions as $alamat)
                            <option value="{{ $alamat['value'] }}">{{ $alamat['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" wire:click="resetFilters">Reset</button>
                    <span class="text-muted align-self-center">{{ $relawans->total() }} data</span>
                </div>
            </div>


            <div class="">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center align-middle">
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>No. WhatsApp</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($relawans as $index => $relawan)
                            <tr>
                                <td class="text-center">{{ $relawans->firstItem() + $index }}</td>
                                <td>{{ $relawan->nama_lengkap }}</td>
                                <td>{{ Str::limit($relawan->alamat, 30) }}</td>
                                <td class="text-center">{{ ucfirst($relawan->jenis_kelamin) }}</td>
                                <td class="text-center">
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $relawan->no_hp) }}"
                                        target="_blank">{{ $relawan->no_hp }}</a>
                                </td>
                                <td class="text-center">
                                    @if ($relawan->status == 'aktif')
                                        <div class="badge text-bg-success">Aktif</div>
                                    @elseif($relawan->status == 'pasif')
                                        <div class="badge text-bg-secondary">Pasif</div>
                                    @endif
                                </td>
                                <td class="d-flex gap-1 justify-content-center">

                                    <div class="btn-group btn-group-sm">

                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal" wire:click="showDetail({{ $relawan->id }})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#relawanModal" wire:click="editRelawan({{ $relawan->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="updateStatus({{ $relawan->id }}, 'aktif')">
                                                        <span class="badge text-bg-success">Aktif</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="updateStatus({{ $relawan->id }}, 'pasif')">
                                                        <span class="badge text-bg-secondary">Pasif</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <p>Belum ada data relawan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $relawans->links() }}
                </div>

                {{-- Detail Modal --}}
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                    aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="detailModalLabel">Detail Relawan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($selectedRelawan)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold text-primary">Data Pribadi</h6>
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <td class="fw-semibold" width="40%">Nama Lengkap</td>
                                                    <td>: {{ $selectedRelawan->nama_lengkap }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Email</td>
                                                    <td>: {{ $selectedRelawan->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">No. HP</td>
                                                    <td>: {{ $selectedRelawan->no_hp }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Jenis Kelamin</td>
                                                    <td>: {{ ucfirst($selectedRelawan->jenis_kelamin) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Tempat Lahir</td>
                                                    <td>: {{ $selectedRelawan->tempat_lahir }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Tanggal Lahir</td>
                                                    <td>:
                                                        {{ \Carbon\Carbon::parse($selectedRelawan->tanggal_lahir)->format('d F Y') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Usia</td>
                                                    <td>: {{ $selectedRelawan->usia }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Pendidikan</td>
                                                    <td>: {{ strtoupper($selectedRelawan->pendidikan_terakhir) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-semibold">Status</td>
                                                    <td>:
                                                        @if ($selectedRelawan->status == 'aktif')
                                                            <span class="badge text-bg-success">Aktif</span>
                                                        @elseif($selectedRelawan->status == 'pasif')
                                                            <span class="badge text-bg-secondary">Pasif</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold text-primary">Alamat</h6>
                                            <p class="text-muted">{{ $selectedRelawan->alamat }}</p>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="fw-bold text-primary">Pertanyaan & Jawaban</h6>

                                            <div class="mb-3">
                                                <strong>1. Motivasi bergabung sebagai relawan:</strong>
                                                <p class="text-muted mt-2">{{ $selectedRelawan->ketertarikan }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <strong>2. Kontribusi yang ingin diberikan:</strong>
                                                <p class="text-muted mt-2">{{ $selectedRelawan->kegiatan }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <strong>3. Persetujuan dokumentasi:</strong>
                                                <p class="text-muted mt-2">{{ $selectedRelawan->dokumentasi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Form -->
            <div class="modal fade" id="relawanModal" tabindex="-1" aria-labelledby="relawanModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="relawanModalLabel">
                                {{ $isEdit ? 'Edit Relawan' : 'Tambah Relawan' }}
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="saveRelawan">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text"
                                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                                wire:model="nama_lengkap">
                                            @error('nama_lengkap')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                wire:model="email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">No. HP</label>
                                            <input type="text"
                                                class="form-control @error('no_hp') is-invalid @enderror"
                                                wire:model="no_hp">
                                            @error('no_hp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                wire:model="jenis_kelamin">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text"
                                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                wire:model="tempat_lahir">
                                            @error('tempat_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                wire:model="tanggal_lahir">
                                            @error('tanggal_lahir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror" wire:model="alamat" rows="3"></textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Usia</label>
                                            <input type="text"
                                                class="form-control @error('usia') is-invalid @enderror"
                                                wire:model="usia">
                                            @error('usia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pendidikan Terakhir</label>
                                            <select
                                                class="form-select @error('pendidikan_terakhir') is-invalid @enderror"
                                                wire:model="pendidikan_terakhir">
                                                <option value="">Pilih Pendidikan</option>
                                                <option value="sd">SD</option>
                                                <option value="smp">SMP</option>
                                                <option value="sma">SMA</option>
                                                <option value="d3">D3</option>
                                                <option value="s1">S1</option>
                                                <option value="s2">S2</option>
                                            </select>
                                            @error('pendidikan_terakhir')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                wire:model="status">
                                                <option value="">Pilih Status</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="pasif">Pasif</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ketertarikan</label>
                                    <textarea class="form-control @error('ketertarikan') is-invalid @enderror" wire:model="ketertarikan" rows="2"></textarea>
                                    @error('ketertarikan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kegiatan</label>
                                    <textarea class="form-control @error('kegiatan') is-invalid @enderror" wire:model="kegiatan" rows="2"></textarea>
                                    @error('kegiatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dokumentasi</label>
                                    <textarea class="form-control @error('dokumentasi') is-invalid @enderror" wire:model="dokumentasi" rows="2"></textarea>
                                    @error('dokumentasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit"
                                    class="btn btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('relawanModal'));
            modal.hide();
        });
    });
</script>
