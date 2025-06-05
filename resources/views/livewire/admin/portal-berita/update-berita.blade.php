<div>
    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Berita</h5>
        </div>
        <div class="card-body">
            <form wire:submit="update">
                <div class="row">
                    <div class="col-md-8">
                        {{-- Judul Berita --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   wire:model="judul"
                                   placeholder="Masukkan judul berita">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Isi Berita --}}
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <textarea id="tinymce-editor-update" 
                                          class="form-control @error('isi') is-invalid @enderror"
                                          wire:model="isi">{!! $isi !!}</textarea>
                            </div>
                            @error('isi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Jenis Bencana --}}
                        <div class="mb-3">
                            <label for="bencana_id" class="form-label">Jenis Bencana <span class="text-danger">*</span></label>
                            <select class="form-select @error('bencana_id') is-invalid @enderror" 
                                    id="bencana_id" 
                                    wire:model="bencana_id">
                                <option value="">Pilih Jenis Bencana</option>
                                @foreach($bencanas as $bencana)
                                    <option value="{{ $bencana->id }}">{{ $bencana->nama_bencana }}</option>
                                @endforeach
                            </select>
                            @error('bencana_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Thumbnail --}}
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" 
                                   class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" 
                                   wire:model="thumbnail"
                                   accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            {{-- Current Thumbnail --}}
                            @if ($existing_thumbnail && !$thumbnail)
                                <div class="mt-2">
                                    <label class="form-label">Thumbnail Saat Ini:</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $existing_thumbnail) }}" 
                                             alt="Current Thumbnail" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Preview New Thumbnail --}}
                            @if ($thumbnail)
                                <div class="mt-2">
                                    <label class="form-label">Preview Thumbnail Baru:</label>
                                    <div>
                                        <img src="{{ $thumbnail->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Status Publikasi --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_published" 
                                       wire:model="is_published">
                                <label class="form-check-label" for="is_published">
                                    Publikasikan
                                </label>
                            </div>
                            <small class="text-muted">Jika tidak dicentang, berita akan disimpan sebagai draft</small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    <i class="fas fa-save me-2"></i>Update Berita
                                </span>
                                <span wire:loading>
                                    <i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...
                                </span>
                            </button>
                            <a href="{{ route('kelola-berita') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TinyMCE Script --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#tinymce-editor-update',
                height: 400,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                images_upload_url: '{{ route("upload.image") }}',
                images_upload_handler: function (blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route("upload.image") }}');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    xhr.onload = function() {
                        var json;
                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                },
                setup: function (editor) {
                    editor.on('change', function () {
                        @this.set('isi', editor.getContent());
                    });
                }
            });
        });
    </script>
    @endpush
</div>
