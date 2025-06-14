<div class="container py-4">
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                Dokumentasi Bencana
            </h5>
        </div>
        <div class="card-body">
            {{-- Form Tambah/Edit --}}
            <form wire:submit.prevent="{{ $editId ? 'update' : 'store' }}" class="mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Bencana</label>
                        <select class="form-select" wire:model="bencana_id" required>
                            <option value="">Pilih Bencana</option>
                            @foreach ($bencanas as $bencana)
                                <option value="{{ $bencana->id }}">{{ $bencana->nama_bencana }} ({{ $bencana->lokasi }})
                                </option>
                            @endforeach
                        </select>
                        @error('bencana_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jenis Media</label>
                        <select class="form-select" wire:model="jenis_media" required>
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                        </select>
                        @error('jenis_media')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">File
                            {{ $editId ? '(pilih jika ingin ganti)' : '(bisa pilih banyak)' }}</label>
                        <input type="file" class="form-control" wire:model="media_files" {{ $editId ? '' : 'multiple' }}
                            {{ $editId ? '' : 'required' }} {{ $jenis_media == 'foto' ? 'accept=image/*' : 'accept=video/*' }}>
                        @error('media_files.*')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" wire:model="keterangan" maxlength="255">
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" type="submit">
                            {{ $editId ? 'Update' : 'Tambah' }}
                        </button>
                    </div>
                    @if ($editId)
                        <div class="col-md-1">
                            <button type="button" class="btn btn-secondary w-100" wire:click="resetForm">Batal</button>
                        </div>
                    @endif
                </div>
                <div wire:loading wire:target="media_files" class="text-info mt-2">Uploading...</div>
            </form>
        
            {{-- Filter --}}
            <div class="row mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari keterangan..."
                        wire:model="search">
                </div>
                <div class="col-md-4">
                    <select class="form-select form-select-sm" wire:model="bencanaFilter">
                        <option value="">Semua Bencana</option>
                        @foreach ($bencanas as $bencana)
                            <option value="{{ $bencana->id }}">{{ $bencana->nama_bencana }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            {{-- Table --}}
            {{-- ...existing code... --}}
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Bencana</th>
                            <th>Jenis</th>
                            <th>Media</th>
                            <th>Keterangan</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($groupedDokumentasi as $group)
                            @foreach ($group as $idx => $d)
                                <tr class="text-center">
                                    <td>{{ $no++ }}</td>
                                    @if ($idx == 0)
                                        <td class="text-start" rowspan="{{ $group->count() }}">
                                            {{ $d->bencana->nama_bencana ?? '-' }}
                                        </td>
                                    @endif
                                    <td>{{ ucfirst($d->jenis_media) }}</td>
                                    <td>
                                        @if ($d->jenis_media == 'foto')
                                            <img src="{{ asset('storage/' . $d->file_path) }}" alt="foto" width="80"
                                                class="img-thumbnail">
                                        @else
                                            <video width="120" controls>
                                                <source src="{{ asset('storage/' . $d->file_path) }}">
                                                Browser tidak mendukung video.
                                            </video>
                                        @endif
                                    </td>
                                        <td class="text-start" >
                                            {{ $d->keterangan }}
                                        </td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                            wire:click="edit({{ $d->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $d->id }})"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- ...existing code... --}}
        </div>
    </div>
</div>
