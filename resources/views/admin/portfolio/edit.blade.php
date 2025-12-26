@extends('admin.layouts.app')

@section('title', 'Edit Portfolio Project')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <a href="{{ route('admin.portfolio.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to
                Portfolio</a>
            <h1>Edit Portfolio Project: {{ $project->title }}</h1>
        </div>
    </div>

    <form action="{{ route('admin.portfolio.update', $project) }}" method="POST" id="projectForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Project Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label" for="title">Project Title</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $project->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="slug">Project Slug</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $project->slug) }}" required>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <label class="form-label" for="client_name">Client Name</label>
                                <input type="text" name="client_name" id="client_name" class="form-control"
                                    value="{{ old('client_name', $project->client_name) }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="project_type">Project Type</label>
                                <input type="text" name="project_type" id="project_type" class="form-control"
                                    value="{{ old('project_type', $project->project_type) }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="challenge">The Challenge</label>
                            <textarea name="challenge" id="challenge" rows="4"
                                class="form-control">{{ old('challenge', $project->challenge) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="solution">The Solution</label>
                            <textarea name="solution" id="solution" rows="4"
                                class="form-control">{{ old('solution', $project->solution) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="result">The Result</label>
                            <textarea name="result" id="result" rows="4"
                                class="form-control">{{ old('result', $project->result) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Technology Stack</label>
                            <div id="tech-stack-container" class="d-flex flex-wrap gap-2 mb-2">
                                @if($project->tech_stack)
                                    @foreach($project->tech_stack as $tech)
                                        <div class="tech-tag">
                                            {{ $tech }}
                                            <button type="button" onclick="this.parentElement.remove()">×</button>
                                            <input type="hidden" name="tech_stack[]" value="{{ $tech }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="input-group">
                                <input type="text" id="tech-input" class="form-control" placeholder="Add a technology">
                                <button type="button" id="add-tech-btn" class="btn btn-secondary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Project Gallery</h3>
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="document.getElementById('gallery-upload').click()">
                            <i class="fas fa-upload me-1"></i> Upload Images
                        </button>
                        <input type="file" id="gallery-upload" hidden multiple accept="image/*">
                    </div>
                    <div class="card-body">
                        <div id="gallery-preview" class="gallery-grid">
                            @if($project->images)
                                @foreach($project->images as $image)
                                    <div class="gallery-item">
                                        <img src="{{ $image }}">
                                        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">×</button>
                                        <input type="hidden" name="images[]" value="{{ $image }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Project Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1"
                                {{ $project->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">Published</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ $project->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Project</label>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Update Project</button>
                            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Cover Image</h3>
                    </div>
                    <div class="card-body">
                        <div id="cover-preview" class="image-preview-container mb-3"
                            onclick="document.getElementById('cover-upload').click()">
                            @if($project->cover_image_url)
                                <img src="{{ $project->cover_image_url }}">
                            @else
                                <div class="preview-placeholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                    <p>Click to upload cover</p>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="cover-upload" hidden accept="image/*">
                        <input type="hidden" name="cover_image_url" id="cover_image_url"
                            value="{{ $project->cover_image_url }}">
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3>External Links</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="project_url">Live URL</label>
                            <input type="url" name="project_url" id="project_url" class="form-control"
                                value="{{ $project->project_url }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="demo_url">Demo URL</label>
                            <input type="url" name="demo_url" id="demo_url" class="form-control"
                                value="{{ $project->demo_url }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="github_url">GitHub URL</label>
                            <input type="url" name="github_url" id="github_url" class="form-control"
                                value="{{ $project->github_url }}">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Media</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="video_url">Video URL (Embed)</label>
                            <input type="url" name="video_url" id="video_url" class="form-control"
                                value="{{ $project->video_url }}">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>SEO Metadata</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label" for="meta_title">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control"
                                value="{{ $project->meta_title }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="meta_description">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                class="form-control">{{ $project->meta_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
        <style>
            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                color: var(--primary);
                text-decoration: none;
                font-weight: 500;
                margin-bottom: 8px;
            }

            .image-preview-container {
                height: 200px;
                border: 2px dashed var(--light-border);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                cursor: pointer;
                background: var(--light-bg);
                transition: all 0.3s;
            }

            body.dark-mode .image-preview-container {
                border-color: var(--dark-border);
                background: var(--dark-bg);
            }

            .image-preview-container:hover {
                border-color: var(--primary);
                background: rgba(59, 130, 246, 0.05);
            }

            .image-preview-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .preview-placeholder {
                text-align: center;
                color: var(--light-muted);
            }

            body.dark-mode .preview-placeholder {
                color: var(--dark-muted);
            }

            .gallery-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 16px;
                margin-top: 15px;
                min-height: 100px;
            }

            .gallery-item {
                position: relative;
                aspect-ratio: 1;
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid var(--light-border);
                box-shadow: var(--shadow-sm);
            }

            body.dark-mode .gallery-item {
                border-color: var(--dark-border);
            }

            .gallery-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .gallery-item .remove-btn {
                position: absolute;
                top: 5px;
                right: 5px;
                background: #ef4444;
                color: white;
                border: none;
                border-radius: 50%;
                width: 22px;
                height: 22px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-size: 12px;
                opacity: 0.9;
                transition: opacity 0.2s;
                z-index: 10;
            }

            .gallery-item .remove-btn:hover {
                opacity: 1;
            }

            .tech-tag {
                background: rgba(59, 130, 246, 0.1);
                color: var(--primary);
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 0.85rem;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border: 1px solid rgba(59, 130, 246, 0.2);
                font-weight: 500;
            }

            body.dark-mode .tech-tag {
                background: rgba(59, 130, 246, 0.15);
            }

            .tech-tag button {
                background: none;
                border: none;
                padding: 0;
                color: #ef4444;
                cursor: pointer;
                font-size: 16px;
                line-height: 1;
            }

            .form-switch .form-check-input {
                width: 40px;
                height: 20px;
                cursor: pointer;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const techInput = document.getElementById('tech-input');
                const addTechBtn = document.getElementById('add-tech-btn');
                const techContainer = document.getElementById('tech-stack-container');

                function addTechTag(value) {
                    value = value.trim();
                    if (!value) return;

                    const tag = document.createElement('div');
                    tag.className = 'tech-tag animated zoomIn';
                    tag.innerHTML = `<span>${value}</span>`;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function () {
                        tag.remove();
                        input.remove();
                    };
                    tag.appendChild(removeBtn);

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'tech_stack[]';
                    input.value = value;

                    hiddenInputs.appendChild(input); // Note: hiddenInputs wasn't defined in edit, let's fix that
                    techContainer.appendChild(tag);
                    techInput.value = '';
                }

                const hiddenInputs = document.createElement('div');
                techContainer.after(hiddenInputs);

                addTechBtn.onclick = (e) => { e.preventDefault(); addTechTag(techInput.value); };
                techInput.onkeydown = (e) => { if (e.key === 'Enter') { e.preventDefault(); addTechTag(techInput.value); } };

                // Cover upload
                document.getElementById('cover-upload').onchange = function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const preview = document.getElementById('cover-preview');
                    const originalContent = preview.innerHTML;
                    preview.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("admin.portfolio.upload-media") }}', { method: 'POST', body: formData })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                preview.innerHTML = `<img src="${data.url}">`;
                                document.getElementById('cover_image_url').value = data.url;
                            } else {
                                preview.innerHTML = originalContent;
                                alert(data.message || 'Upload failed');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            preview.innerHTML = originalContent;
                            alert('An error occurred during upload.');
                        });
                };

                // Gallery upload
                document.getElementById('gallery-upload').onchange = function (e) {
                    const files = e.target.files;
                    const preview = document.getElementById('gallery-preview');

                    for (let file of files) {
                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch('{{ route("admin.portfolio.upload-media") }}', { method: 'POST', body: formData })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const item = document.createElement('div');
                                    item.className = 'gallery-item animated fadeIn';
                                    item.innerHTML = `
                                                <img src="${data.url}">
                                                <button type="button" class="remove-btn" title="Remove image">×</button>
                                                <input type="hidden" name="images[]" value="${data.url}">
                                            `;
                                    item.querySelector('.remove-btn').onclick = function () {
                                        item.remove();
                                    };
                                    preview.appendChild(item);
                                } else {
                                    alert(data.message || 'Gallery upload failed');
                                }
                            })
                            .catch(err => console.error('Gallery upload error:', err));
                    }
                };
            });
        </script>
    @endpush
@endsection