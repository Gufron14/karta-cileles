<div class="container py-4">
    <h4 class="mb-4">Dokumentasi Bencana</h4>
    <div class="row">
        @php
            // Kelompokkan dokumentasi per bencana
            $grouped = $dokumentasi->groupBy('bencana_id');
            $carouselId = 1;
        @endphp
        @foreach($grouped->chunk(2) as $rowGroup)
            <div class="row mb-4">
                @foreach($rowGroup as $bencanaId => $items)
                    @php
                        $bencana = $items->first()->bencana;
                        $berita = $bencana && $bencana->beritas && $bencana->beritas->first() ? $bencana->beritas->first() : null;
                        $carouselKey = 'carouselBencana' . $carouselId++;
                        $fotoItems = $items->where('jenis_media', 'foto');
                        $videoItems = $items->where('jenis_media', 'video');
                    @endphp
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">{{ $bencana->nama_bencana ?? '-' }}</h6>
                            </div>
                            <div class="card-body">
                                {{-- Carousel Foto --}}
                                @if($fotoItems->count())
                                    <div id="{{ $carouselKey }}" class="carousel slide mb-2" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($fotoItems as $idx => $foto)
                                                <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/'.$foto->file_path) }}" class="d-block w-100" alt="foto bencana" style="object-fit:cover; height:260px;">
                                                    @if($foto->keterangan)
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <small class="bg-dark bg-opacity-50 px-2 rounded">{{ $foto->keterangan }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($fotoItems->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselKey }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselKey }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        @endif
                                    </div>
                                @endif

                                {{-- Video --}}
                                @foreach($videoItems as $video)
                                    <div class="mb-2">
                                        <video class="w-100" style="object-fit:cover; height:260px;" controls>
                                            <source src="{{ asset('storage/'.$video->file_path) }}">
                                            Browser tidak mendukung video.
                                        </video>
                                        @if($video->keterangan)
                                            <div>
                                                <small class="text-muted">{{ $video->keterangan }}</small>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer bg-white">
                                @if($berita)
                                    <a href="{{ route('detailBerita', $berita->slug) }}" class="btn btn-primary btn-sm">Lihat Berita</a>
                                @else
                                    <span class="text-muted">Belum ada berita</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>