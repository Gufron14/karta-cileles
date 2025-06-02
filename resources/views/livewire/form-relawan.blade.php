<div class="container p-5">
    <div class="card border-0 shadow">
        <div class="card-body p-5">
            <div class="mb-">
                <h3 class="fw-bold">Formulir Pendaftaran Relawan</h3>
                <span>Karang Taruna Kecamatan Cileles</span>
            </div>
            <hr class="my-4">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form wire:submit.prevent="daftar">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   wire:model="email" id="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                   wire:model="nama_lengkap" id="nama_lengkap">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control @error('no_hp') is-invalid @enderror" 
                                   wire:model="no_hp" id="no_hp">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex gap-3">
                            <div class="col mb-3">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       wire:model="tempat_lahir" id="tempat_lahir">
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       wire:model="tanggal_lahir" id="tanggal_lahir">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      wire:model="alamat" id="alamat" rows="3"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="usia" class="form-label">Usia</label>
                            <select class="form-select @error('usia') is-invalid @enderror" 
                                    wire:model="usia" id="usia">
                                <option value="">-- Pilih Usia --</option>
                                <option value="18">18 Tahun</option>
                                <option value="18-20">18 - 20 Tahun</option>
                                <option value="21-24">21 - 24 Tahun</option>
                            </select>
                            @error('usia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror" 
                                    wire:model="pendidikan_terakhir" id="pendidikan_terakhir">
                                <option value="">-- Pilih Pendidikan Terakhir --</option>
                                <option value="sd">SD / Sederajat</option>
                                <option value="smp">SMP / Sederajat</option>
                                <option value="sma">SMA / Sederajat</option>
                                <option value="d1">Diploma I (D1)</option>
                                <option value="d2">Diploma II (D2)</option>
                                <option value="d3">Diploma III (D3)</option>
                                <option value="d4">Diploma IV (D4) / Sarjana Terapan</option>
                                <option value="s1">Sarjana (S1)</option>
                                <option value="s2">Magister (S2)</option>
                                <option value="s3">Doktor (S3)</option>
                            </select>
                            @error('pendidikan_terakhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    wire:model="jenis_kelamin" id="jenis_kelamin">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <h4 class="mb-3">Jawablah Pertanyaan-pertanyaan berikut:</h4>
                <div class="mb-3">
                    <label class="form-label">Apa yang mendorong Anda untuk bergabung sebagai relawan dalam kegiatan Karang Taruna Kecamatan Cileles?</label>
                    <textarea wire:model='ketertarikan' class="form-control @error('ketertarikan') is-invalid @enderror" 
                              rows="3" placeholder="Ceritakan motivasi Anda, nilai-nilai yang Anda yakini, atau pengalaman yang menginspirasi Anda untuk turut berkontribusi."></textarea>
                    @error('ketertarikan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Jika terpilih menjadi relawan, kontribusi atau peran seperti apa yang ingin Anda berikan dalam kegiatan ini?</label>
                    <textarea wire:model='kegiatan' class="form-control @error('kegiatan') is-invalid @enderror" 
                              rows="3" placeholder="Sampaikan ide, keterampilan, atau komitmen yang ingin Anda tawarkan selama menjadi bagian dari tim relawan."></textarea>
                    @error('kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Sebagai bagian dari dokumentasi kegiatan, apakah Anda bersedia apabila foto dan/atau video Anda diambil serta dipublikasikan melalui media sosial atau platform resmi Karang Taruna Kecamatan Cileles?</label>
                    <textarea wire:model='dokumentasi' class="form-control @error('dokumentasi') is-invalid @enderror" 
                              rows="3" placeholder="(Kami akan tetap mengutamakan kenyamanan dan privasi setiap relawan.)"></textarea>
                    @error('dokumentasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-4 fw-bold">Daftar Sekarang</button>
            </form>
        </div>
    </div>
</div>
