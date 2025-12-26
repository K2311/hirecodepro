@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title"><i class="fas fa-edit"></i> Edit Category</h1>
            <p class="page-subtitle">Update category details</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary"><i
                    class="fas fa-arrow-left"></i> Back</a>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="product-form">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Basic</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $category->slug) }}">
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description"
                                class="form-control">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control"
                                value="{{ old('sort_order', $category->sort_order) }}">
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body d-flex justify-content-end">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </div>
    </form>

@endsection

@push('styles')
    <style>
        /* CKEditor Custom Styling */
        .ck-editor__editable_current {
            min-height: 300px;
        }

        .ck.ck-editor__main>.ck-editor__editable {
            background: #fff;
            min-height: 300px;
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
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        class MyUploadAdapter {
            constructor(loader) { this.loader = loader; }
            upload() { return this.loader.file.then(file => new Promise((resolve, reject) => { this._initRequest(); this._initListeners(resolve, reject, file); this._sendRequest(file); })); }
            abort() { if (this.xhr) { this.xhr.abort(); } }
            _initRequest() { const xhr = this.xhr = new XMLHttpRequest(); xhr.open('POST', '{{ route("admin.products.upload-media") }}', true); xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); xhr.responseType = 'json'; }
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
            ClassicEditor.create(document.querySelector('#description'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: { items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|', 'undo', 'redo'] }
            }).catch(error => { console.error(error); });
        });
    </script>
@endpush