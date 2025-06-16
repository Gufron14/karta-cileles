<div>
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Berita</h5>
            <a class="btn btn-sm btn-primary" href="{{ route('createBerita') }}">
                <i class="fas fa-plus me-2"></i>Tambah Berita
            </a>
        </div>
        <div class="card-body">
            {{-- Search Bar dan Filter --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Cari berita..." wire:model.live="search">
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="bencana_filter">
                        <option value="">Semua Jenis Bencana</option>
                        @foreach($bencanas as $bencana)
                            <option value="{{ $bencana->id }}">{{ $bencana->nama_bencana }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="status_filter">
                        <option value="">Semua Status</option>
                        <option value="1">Dipublikasi</option>
                        <option value="0">Draft</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="text-center align-items-center">
                            <th style="width: 5%">No</th>
                            <th style="width: 40%">Judul Berita</th>
                            <th style="width: 15%">Jenis Bencana</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beritas as $index => $berita)
                            <tr>
                                <td class="text-center align-middle">{{ $beritas->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($berita->thumbnail)
                                            <img src="{{ asset('storage/' . $berita->thumbnail) }}" 
                                                 alt="Thumbnail" 
                                                 class="rounded me-2" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-image text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ Str::limit($berita->judul, 50) }}</div>
                                            <small class="text-muted">{{ $berita->created_at->format('d M Y, H:i') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge bg-info">{{ $berita->bencana->nama_bencana }}</span>
                                </td>
                                <td class="text-center align-middle">
                                    @if($berita->is_published)
                                        <span class="badge bg-success">Dipublikasi</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group" role="group">
                                        {{-- Toggle Status --}}
                                        <button type="button" 
                                                class="btn btn-sm {{ $berita->is_published ? 'btn-warning' : 'btn-success' }}"
                                                wire:click="toggleStatus({{ $berita->id }})"
                                                wire:confirm="Apakah Anda yakin ingin mengubah status berita ini?">
                                            <i class="fas {{ $berita->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                        
                                        {{-- Edit --}}
                                        <a href="{{ route('editBeritaId', $berita->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Detail --}}
                                        <a href="{{ route('detailBerita', $berita->slug) }}" 
                                           class="btn btn-sm btn-info"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        
                                        {{-- Delete --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger"
                                                wire:click="deleteBerita({{ $berita->id }})"
                                                wire:confirm="Apakah Anda yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan.">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-newspaper fa-3x mb-3"></i>
                                        <p>Tidak ada berita yang ditemukan</p>
                                        @if($search || $bencana_filter || $status_filter !== '')
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    wire:click="$set('search', ''); $set('bencana_filter', ''); $set('status_filter', '')">
                                                Reset Filter
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($beritas->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $beritas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
