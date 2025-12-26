@extends('admin.layouts.app')

@section('title', 'Edit Blog Post | CodeCraft Studio')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold">
                <a href="{{ route('admin.blog-posts.index') }}" class="text-muted decoration-none me-2"><i
                        class="fas fa-arrow-left"></i></a>
                Edit: {{ $post->title }}
            </h1>
        </div>
    </div>

    <form action="{{ route('admin.blog-posts.update', $post) }}" method="POST" id="postForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-xl-8">
                <!-- Main Content Card -->
                <div class="premium-card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Post Title</label>
                            <input type="text" name="title" id="title"
                                class="form-input-premium @error('title') is-invalid @enderror"
                                value="{{ old('title', $post->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">URL Slug</label>
                            <div class="input-group">
                                <span
                                    class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted small"
                                    style="border-radius: 12px 0 0 12px;">{{ url('/blog/') }}/</span>
                                <input type="text" name="slug" id="slug" class="form-input-premium rounded-start-0"
                                    value="{{ old('slug', $post->slug) }}" required style="border-radius: 0 12px 12px 0;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Post Excerpt</label>
                            <textarea name="excerpt" id="excerpt" rows="3"
                                class="form-input-premium h-auto">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Post Content</label>
                            <textarea name="content" id="post-content" rows="15"
                                class="form-input-premium">{{ old('content', $post->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SEO Optimization Card -->
                <div class="premium-card border-0 shadow-sm">
                    <div class="card-header-premium bg-white py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-search me-2 text-info"></i>SEO Optimization</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-input-premium"
                                value="{{ old('meta_title', $post->meta_title) }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Meta
                                Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                class="form-input-premium h-auto">{{ old('meta_description', $post->meta_description) }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Meta
                                Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" class="form-input-premium"
                                value="{{ old('meta_keywords', $post->meta_keywords) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Publish Settings Card -->
                <div class="premium-card border-0 shadow-sm mb-4">
                    <div class="card-header-premium bg-white py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-paper-plane me-2 text-primary"></i>Publish
                            Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Post Status</label>
                            <div class="select-wrapper">
                                <select name="status" id="status" class="form-select-premium fw-bold">
                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="scheduled" {{ old('status', $post->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                </select>
                                <i class="fas fa-chevron-down select-icon"></i>
                            </div>
                        </div>

                        <div id="scheduled_date_container"
                            class="mb-4 {{ old('status', $post->status) == 'scheduled' ? '' : 'd-none' }}">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Publish Date</label>
                            <input type="datetime-local" name="published_at" id="published_at" class="form-input-premium"
                                value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="form-check form-switch mb-4 d-flex align-items-center gap-3 ps-0">
                            <input class="form-check-input ms-0" type="checkbox" name="is_featured" id="is_featured"
                                value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                style="width: 2.8rem; height: 1.4rem;">
                            <label class="form-check-label fw-bold text-dark" for="is_featured">Feature this post</label>
                        </div>

                        <div class="text-muted small mb-4 p-3 rounded-3 bg-light">
                            <div class="mb-1"><strong>Created:</strong> {{ $post->created_at->format('M d, Y H:i') }}</div>
                            @if($post->updated_at != $post->created_at)
                                <div><strong>Updated:</strong> {{ $post->updated_at->format('M d, Y H:i') }}</div>
                            @endif
                        </div>

                        <hr class="opacity-10 my-4">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm">Update Blog
                                Post</button>
                            <a href="{{ route('admin.blog-posts.index') }}"
                                class="btn btn-outline-secondary rounded-pill py-2">Cancel</a>
                        </div>
                    </div>
                </div>

                <!-- Category Card -->
                <div class="premium-card border-0 shadow-sm mb-4">
                    <div class="card-header-premium bg-white py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-tags me-2 text-warning"></i>Category</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="select-wrapper">
                            <select name="category_id"
                                class="form-select-premium @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down select-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Featured Image Card -->
                <div class="premium-card border-0 shadow-sm">
                    <div class="card-header-premium bg-white py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-image me-2 text-success"></i>Featured Image</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div id="cover-preview" class="image-upload-preview mb-3 shadow-sm"
                            onclick="document.getElementById('cover-upload').click()">
                            @if($post->cover_image_url)
                                <img src="{{ $post->cover_image_url }}" alt="Featured Image">
                            @else
                                <div class="preview-placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0 fw-bold text-muted small">Click to change </p>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="cover-upload" hidden accept="image/*">
                        <input type="hidden" name="cover_image_url" id="cover_image_url"
                            value="{{ $post->cover_image_url }}">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .ls-1 {
            letter-spacing: 1px;
        }

        .decoration-none {
            text-decoration: none;
        }

        .premium-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
        }

        body.dark-mode .premium-card {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
        }

        .card-header-premium {
            border-bottom: 1px solid #f1f5f9;
        }

        body.dark-mode .card-header-premium {
            border-color: var(--dark-border);
            background: transparent !important;
        }

        .form-input-premium,
        .form-select-premium {
            width: 100%;
            height: 48px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            display: block;
            outline: none;
            transition: all 0.2s;
        }

        body.dark-mode .form-input-premium,
        body.dark-mode .form-select-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .form-input-premium:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .select-wrapper {
            position: relative;
        }

        .select-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            opacity: 0.7;
        }

        .image-upload-preview {
            height: 220px;
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: pointer;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        body.dark-mode .image-upload-preview {
            border-color: var(--dark-border);
            background: rgba(255, 255, 255, 0.02);
        }

        .image-upload-preview:hover {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.05);
        }

        .image-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CKEditor Custom Styling */
        .ck-editor__editable_current {
            min-height: 400px;
        }

        .ck.ck-editor__main>.ck-editor__editable {
            background: #fff;
            min-height: 400px;
            border-radius: 0 0 12px 12px !important;
        }

        body.dark-mode .ck.ck-editor__main>.ck-editor__editable {
            background: var(--dark-bg);
            color: var(--dark-text);
            border-color: var(--dark-border);
        }

        body.dark-mode .ck.ck-toolbar {
            background: var(--dark-card) !important;
            border-color: var(--dark-border) !important;
            border-radius: 12px 12px 0 0 !important;
        }

        body.dark-mode .ck.ck-toolbar__items .ck-button {
            color: var(--dark-text) !important;
        }

        body.dark-mode .ck.ck-toolbar__items .ck-button:hover {
            background: var(--dark-bg) !important;
        }

        body.dark-mode .ck.ck-button.ck-on {
            background: var(--primary) !important;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <script>
            class MyUploadAdapter {
                constructor(loader) { this.loader = loader; }
                upload() { return this.loader.file.then(file => new Promise((resolve, reject) => { this._initRequest(); this._initListeners(resolve, reject, file); this._sendRequest(file); })); }
                abort() { if (this.xhr) { this.xhr.abort(); } }
                _initRequest() { const xhr = this.xhr = new XMLHttpRequest(); xhr.open('POST', '{{ route("admin.blog-posts.upload-media") }}', true); xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); xhr.responseType = 'json'; }
                _initListeners(resolve, reject, file) {
                    const xhr = this.xhr; const loader = this.loader; const genericErrorText = `Couldn't upload file: ${file.name}.`;
                    xhr.addEventListener('error', () => reject(genericErrorText));
                    xhr.addEventListener('abort', () => reject());
                    xhr.addEventListener('load', () => {
                        const response = xhr.response;
                        if (!response || response.success === false) { return reject(response && response.message ? response.message : genericErrorText); }
                        resolve({ default: response.url });
                    });
                    if (xhr.upload) { xhr.upload.addEventListener('progress', evt => { if (evt.lengthComputable) { loader.uploadTotal = evt.total; loader.uploaded = evt.loaded; } }); }
                }
                _sendRequest(file) { const data = new FormData(); data.append('file', file); this.xhr.send(data); }
            }

            function MyCustomUploadAdapterPlugin(editor) { editor.plugins.get('FileRepository').createUploadAdapter = (loader) => { return new MyUploadAdapter(loader); }; }

            document.addEventListener('DOMContentLoaded', function () {
                ClassicEditor.create(document.querySelector('#post-content'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: { items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|', 'undo', 'redo'] }
                }).catch(error => { console.error(error); });

                const statusSelect = document.getElementById('status');
                const scheduledContainer = document.getElementById('scheduled_date_container');

                statusSelect.onchange = function () {
                    if (this.value === 'scheduled') { scheduledContainer.classList.remove('d-none'); }
                    else { scheduledContainer.classList.add('d-none'); }
                };

                // Image upload handler
                document.getElementById('cover-upload').onchange = function (e) {
                    const file = e.target.files[0]; if (!file) return;
                    const preview = document.getElementById('cover-preview');
                    const originalContent = preview.innerHTML;
                    preview.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
                    const formData = new FormData(); formData.append('file', file); formData.append('_token', '{{ csrf_token() }}');
                    fetch('{{ route("admin.blog-posts.upload-media") }}', { method: 'POST', body: formData })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) { preview.innerHTML = `<img src="${data.url}">`; document.getElementById('cover_image_url').value = data.url; }
                            else { preview.innerHTML = originalContent; alert(data.message || 'Upload failed'); }
                        }).catch(err => { preview.innerHTML = originalContent; alert('Upload error occurred'); });
                };
            });
        </script>
    @endpush
@endsection