@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <i class="fas fa-plus"></i>
            Create Product
        </h1>
        <p class="page-subtitle">Add a new code product, template, or digital asset</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Products
        </a>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h5 class="alert-heading mb-3">
        <i class="fas fa-exclamation-triangle"></i> Please fix the following errors
    </h5>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="{{ route('admin.products.store') }}" method="POST" id="productForm" class="product-form" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label required">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug (URL)</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug') }}">
                                <small class="form-text text-muted">Leave empty to auto-generate from name</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label required">Short Description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description" name="short_description" rows="3"
                                  placeholder="Brief description for product listings...">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="full_description" class="form-label">Full Description</label>
                        <textarea class="form-control @error('full_description') is-invalid @enderror"
                                  id="full_description" name="full_description" rows="6"
                                  placeholder="Detailed product description, features, etc...">{{ old('full_description') }}</textarea>
                        @error('full_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="features" class="form-label">Key Features</label>
                        <textarea class="form-control @error('features') is-invalid @enderror"
                                  id="features" name="features" rows="4"
                                  placeholder="List key features (one per line or comma-separated)...">{{ old('features') }}</textarea>
                        <small class="form-text text-muted">Enter features separated by new lines or commas</small>
                        @error('features')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Licensing -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-dollar-sign"></i>
                        Pricing & Licensing
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="base_price" class="form-label required">Base Price ($)</label>
                                <input type="number" class="form-control @error('base_price') is-invalid @enderror"
                                       id="base_price" name="base_price" value="{{ old('base_price') }}"
                                       step="0.01" min="0">
                                @error('base_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sale_price" class="form-label">Sale Price ($)</label>
                                <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                       id="sale_price" name="sale_price" value="{{ old('sale_price') }}"
                                       step="0.01" min="0">
                                <small class="form-text text-muted">Leave empty if not on sale</small>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="cost_price" class="form-label">Cost Price ($)</label>
                                <input type="number" class="form-control @error('cost_price') is-invalid @enderror"
                                       id="cost_price" name="cost_price" value="{{ old('cost_price') }}"
                                       step="0.01" min="0">
                                <small class="form-text text-muted">Your cost for this product</small>
                                @error('cost_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="license_type" class="form-label required">License Type</label>
                                <select class="form-select @error('license_type') is-invalid @enderror"
                                        id="license_type" name="license_type">
                                    <option value="">Select license type</option>
                                    <option value="single_project" {{ old('license_type') === 'single_project' ? 'selected' : '' }}>Single Project</option>
                                    <option value="multiple_projects" {{ old('license_type') === 'multiple_projects' ? 'selected' : '' }}>Multiple Projects</option>
                                    <option value="enterprise" {{ old('license_type') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                                    <option value="personal" {{ old('license_type') === 'personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="commercial" {{ old('license_type') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                                </select>
                                @error('license_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="version" class="form-label required">Version</label>
                                <input type="text" class="form-control @error('version') is-invalid @enderror"
                                    id="version" name="version" value="{{ old('version', '1.0.0') }}"
                                    placeholder="e.g., 1.0.0" required>
                                @error('version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="license_terms" class="form-label">License Terms</label>
                        <textarea class="form-control @error('license_terms') is-invalid @enderror"
                                  id="license_terms" name="license_terms" rows="3"
                                  placeholder="Detailed license terms and conditions...">{{ old('license_terms') }}</textarea>
                        @error('license_terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Technical Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-code"></i>
                        Technical Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_type" class="form-label required">Product Type</label>
                                <select class="form-select @error('product_type') is-invalid @enderror"
                                        id="product_type" name="product_type">
                                    <option value="">Select product type</option>
                                    <option value="code" {{ old('product_type') === 'code' ? 'selected' : '' }}>Code</option>
                                    <option value="template" {{ old('product_type') === 'template' ? 'selected' : '' }}>Template</option>
                                    <option value="api" {{ old('product_type') === 'api' ? 'selected' : '' }}>API</option>
                                    <option value="plugin" {{ old('product_type') === 'plugin' ? 'selected' : '' }}>Plugin</option>
                                    <option value="tool" {{ old('product_type') === 'tool' ? 'selected' : '' }}>Tool</option>
                                    <option value="ebook" {{ old('product_type') === 'ebook' ? 'selected' : '' }}>Ebook</option>
                                </select>
                                @error('product_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label required">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id">
                                    <option value="">Select category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tech_stack_input" class="form-label">Technology Stack</label>
                        <input type="text" class="form-control @error('tech_stack') is-invalid @enderror"
                               id="tech_stack_input" value="{{ old('tech_stack_input') }}"
                               placeholder="e.g., Laravel, React, Node.js">
                        <small class="form-text text-muted">Press Enter to add multiple technologies</small>
                        <div id="tech-stack-tags" class="mt-2">
                            <!-- Hidden inputs will be added here by JavaScript -->
                        </div>
                        @error('tech_stack')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('tech_stack.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dependencies" class="form-label">Dependencies</label>
                        <textarea class="form-control @error('dependencies') is-invalid @enderror"
                                  id="dependencies" name="dependencies" rows="3"
                                  placeholder="List required dependencies, frameworks, libraries...">{{ old('dependencies') }}</textarea>
                        @error('dependencies')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="requirements" class="form-label">System Requirements</label>
                        <textarea class="form-control @error('requirements') is-invalid @enderror"
                                  id="requirements" name="requirements" rows="3"
                                  placeholder="Minimum system requirements, PHP version, etc...">{{ old('requirements') }}</textarea>
                        @error('requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Links & Resources -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link"></i>
                        Links & Resources
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="demo_url" class="form-label">Demo URL</label>
                                <input type="url" class="form-control @error('demo_url') is-invalid @enderror"
                                       id="demo_url" name="demo_url" value="{{ old('demo_url') }}"
                                       placeholder="https://demo.example.com">
                                @error('demo_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="documentation_url" class="form-label">Documentation URL</label>
                                <input type="url" class="form-control @error('documentation_url') is-invalid @enderror"
                                       id="documentation_url" name="documentation_url" value="{{ old('documentation_url') }}"
                                       placeholder="https://docs.example.com">
                                @error('documentation_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="github_url" class="form-label">GitHub Repository</label>
                                <input type="url" class="form-control @error('github_url') is-invalid @enderror"
                                       id="github_url" name="github_url" value="{{ old('github_url') }}"
                                       placeholder="https://github.com/user/repo">
                                @error('github_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-images"></i>
                        Media
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Cover Media -->
                    <div class="mb-5">
                        <label class="form-label fw-600 mb-3">Cover Media (Image, Video, or URL)</label>
                        
                        <!-- Manual URL Input -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                            <input type="text" class="form-control" name="cover_image_url" id="cover_image_url" 
                                   value="{{ old('cover_image_url') }}" placeholder="Enter image URL or upload file below">
                            <button class="btn btn-outline-secondary" type="button" id="update-cover-btn">
                                Update Preview
                            </button>
                        </div>
                        @error('cover_image_url')
                            <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                        @enderror

                        <div id="cover-dropzone" class="media-dropzone p-5 text-center mb-3">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 d-block text-primary"></i>
                            <p class="fw-500 mb-2">Drag & drop cover image/video here</p>
                            <p class="mb-3"><button type="button" class="btn btn-link p-0" onclick="document.getElementById('cover-file-input').click(); return false;">or browse files</button></p>
                            <small class="d-block text-muted">Supported: JPG, PNG, GIF, MP4, WebM (Max 50MB)</small>
                            <input type="file" id="cover-file-input" accept="image/*,video/*" style="display:none;">
                        </div>

                        <div id="cover-preview" class="d-none">
                            <label class="form-label small text-muted">Preview:</label>
                            <div id="cover-preview-content" class="mb-3"></div>
                            <div id="cover-progress-wrapper" class="d-none mb-3">
                                <small class="d-block mb-2 text-muted">Uploading...</small>
                                <div class="progress" style="height: 28px;">
                                    <div id="cover-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-cover-btn" onclick="removeCover(); return false;">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery -->
                    <div>
                        <label class="form-label fw-600 mb-3">Gallery (Images or Videos)</label>
                        
                        <!-- Manual URL Input for Gallery -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="gallery-url-input" placeholder="Add media by URL">
                            <button class="btn btn-outline-secondary" type="button" id="add-gallery-url-btn">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>

                        <div id="gallery-dropzone" class="media-dropzone p-5 text-center mb-4">
                            <i class="fas fa-cloud-upload-alt fa-3x mb-3 d-block text-primary"></i>
                            <p class="fw-500 mb-2">Drag & drop images/videos here</p>
                            <p class="mb-3"><button type="button" class="btn btn-link p-0" onclick="document.getElementById('gallery-file-input').click(); return false;">or browse files</button></p>
                            <small class="d-block text-muted">Supported: JPG, PNG, GIF, MP4, WebM (multiple files allowed)</small>
                            <input type="file" id="gallery-file-input" accept="image/*,video/*" multiple style="display:none;">
                        </div>

                        <!-- Gallery Progress -->
                        <div id="gallery-progress-wrapper" class="d-none mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Uploading media...</small>
                                <small class="text-muted" id="gallery-upload-stats">0%</small>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div id="gallery-progress" class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>

                        <div id="gallery-previews" class="gallery-items-container"></div>
                        <input type="hidden" name="preview_images" id="gallery-urls-input" value="{{ old('preview_images', '[]') }}">
                        @error('preview_images')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @error('preview_images.*')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status & Visibility -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-eye"></i>
                        Status & Visibility
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status">
                            <option value="">Select status</option>
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at" value="{{ old('published_at') }}">
                        <small class="form-text text-muted">Leave empty to publish immediately when status is active</small>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Product
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_on_sale" name="is_on_sale" value="1"
                               {{ old('is_on_sale') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_on_sale">
                            On Sale
                        </label>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search"></i>
                        SEO Settings
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                               id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                               maxlength="255">
                        <small class="form-text text-muted">Leave empty to use product name</small>
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  id="meta_description" name="meta_description" rows="3"
                                  maxlength="500">{{ old('meta_description') }}</textarea>
                        <small class="form-text text-muted">Leave empty to use short description</small>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                               id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                               placeholder="keyword1, keyword2, keyword3">
                        @error('meta_keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Changelog -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history"></i>
                        Changelog
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="changelog" class="form-label">Version Changelog</label>
                        <textarea class="form-control @error('changelog') is-invalid @enderror"
                                  id="changelog" name="changelog" rows="4"
                                  placeholder="What's new in this version...">{{ old('changelog') }}</textarea>
                        @error('changelog')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Fields marked with <span class="text-danger">*</span> are required</small>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Create Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    let isSlugManual = false;

    nameInput.addEventListener('input', function() {
        if (!isSlugManual || slugInput.value === '') {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            slugInput.value = slug;
            if (slugInput.value === '') isSlugManual = false;
        }
    });

    slugInput.addEventListener('input', function() {
        isSlugManual = this.value.length > 0;
    });

    // ============================================
    // TECHNOLOGY STACK TAGS - FIXED VERSION
    // ============================================
    const techStackInput = document.getElementById('tech_stack_input');
    const techStackTags = document.getElementById('tech-stack-tags');
    let techStackArray = [];

    // Initialize tech stack from old input
    const oldTechStack = @json(old('tech_stack', []));
    if (oldTechStack && oldTechStack.length > 0 && Array.isArray(oldTechStack)) {
        techStackArray = oldTechStack.filter(item => item !== null && item.trim() !== '');
        updateTechStackTags();
    }

    techStackInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const value = this.value.trim();
            if (value && !techStackArray.includes(value)) {
                techStackArray.push(value);
                updateTechStackTags();
                this.value = '';
            }
        }
    });

    function updateTechStackTags() {
        techStackTags.innerHTML = '';
        
        // Create tags display
        techStackArray.forEach((tech, index) => {
            const tag = document.createElement('span');
            tag.className = 'badge bg-primary me-2 mb-2';
            tag.style.cssText = 'display: inline-flex; align-items: center; padding: 0.35em 0.65em 0.35em 0.9em;';
            tag.innerHTML = `${tech} <button type="button" class="tag-remove" onclick="removeTechStack(${index})" style="background: transparent; border: none; color: white; font-size: 1.2em; margin-left: 5px; cursor: pointer; padding: 0 0.2em 0 0.4em;">&times;</button>`;
            techStackTags.appendChild(tag);
        });

        // Remove all existing hidden inputs
        const existingHiddenInputs = techStackTags.querySelectorAll('input[type="hidden"]');
        existingHiddenInputs.forEach(input => input.remove());

        // Create hidden inputs for each tech stack item
        techStackArray.forEach(tech => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tech_stack[]';
            hiddenInput.value = tech;
            techStackTags.appendChild(hiddenInput);
        });
    }

    window.removeTechStack = function(index) {
        techStackArray.splice(index, 1);
        updateTechStackTags();
    };

    // ============================================
    // FORM SUBMISSION HANDLER
    // ============================================
    const form = document.getElementById('productForm');
    form.addEventListener('submit', function(e) {
        // Ensure tech stack hidden inputs are updated before submission
        updateTechStackTags();
        
        // Only disable button to prevent double submit
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        }
    });

    // ============================================
    // MEDIA UPLOAD HANDLING (RICH GALLERY)
    // ============================================
    let galleryArray = [];
    const galleryPreviews = document.getElementById('gallery-previews');
    const galleryUrlsInput = document.getElementById('gallery-urls-input');

    // Initialize gallery
    try {
        const rawValue = galleryUrlsInput.value;
        if (rawValue) {
            const parsed = JSON.parse(rawValue);
            // Enhance old string-only items to object structure
            galleryArray = parsed.map(item => {
                if (typeof item === 'string') {
                    return { url: item, module: '', title: '', description: '' };
                }
                return item;
            });
        }
    } catch (e) {
        console.error('Error parsing gallery JSON:', e);
        galleryArray = [];
    }
    
    // Initial render
    renderGallery();

    // Helper functions (same as before)
    function isImageFile(url) { 
        return /\.(jpg|jpeg|png|gif|webp|bmp)(\?.*)?$/i.test(url); 
    }
    function isVideoFile(url) { 
        return /\.(mp4|webm|ogg|mov|avi)(\?.*)?$/i.test(url); 
    }
    function isYouTubeUrl(url) { 
        return /youtube\.com|youtu\.be/.test(url); 
    }
    function youtubeEmbed(url) {
        const m = url.match(/(youtube\.com.*v=|youtu.be\/)([a-zA-Z0-9_-]{6,})/);
        const id = m ? m[2] : '';
        return id ? 'https://www.youtube.com/embed/' + id : url;
    }

    // Create media preview element
    function createMediaPreview(url, type = 'thumb') {
        const container = document.createElement('div');
        container.style.width = '100%';
        container.style.height = '100%';
        container.className = 'rounded overflow-hidden bg-light d-flex align-items-center justify-content-center';

        if (isYouTubeUrl(url)) {
            const iframe = document.createElement('iframe');
            iframe.src = youtubeEmbed(url);
            iframe.style.width = '100%';
            iframe.style.aspectRatio = '16/9';
            iframe.frameBorder = '0';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            iframe.allowFullscreen = true;
            container.appendChild(iframe);
        } else if (isVideoFile(url)) {
            const video = document.createElement('video');
            video.src = url;
            video.controls = true;
            video.style.width = '100%';
            video.style.maxHeight = '200px';
            container.appendChild(video);
        } else {
            const img = document.createElement('img');
            img.src = url;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.minHeight = '150px';
            img.onerror = function() {
                this.onerror = null;
                this.src = 'https://via.placeholder.com/150?text=Image+Not+Found';
            };
            container.appendChild(img);
        }
        return container;
    }

    function renderGallery() {
        galleryPreviews.innerHTML = '';
        galleryArray.forEach((item, idx) => {
            const row = document.createElement('div');
            row.className = 'card mb-3 shadow-sm border';
            
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body p-3';
            
            const gridRow = document.createElement('div');
            gridRow.className = 'row g-3 align-items-center';

            // Col 1: Image Preview (3 columns)
            const colImg = document.createElement('div');
            colImg.className = 'col-md-3';
            const previewContainer = document.createElement('div');
            previewContainer.style.height = '160px'; // fixed height for consistency
            previewContainer.appendChild(createMediaPreview(item.url));
            colImg.appendChild(previewContainer);
            
            // Col 2: Inputs (8 columns)
            const colInputs = document.createElement('div');
            colInputs.className = 'col-md-8';
            
            // Module Name Input (Used for Tabs)
            const moduleGroup = document.createElement('div');
            moduleGroup.className = 'mb-2';
            const moduleInput = document.createElement('input');
            moduleInput.type = 'text';
            moduleInput.className = 'form-control font-weight-bold';
            moduleInput.style.borderLeft = '4px solid var(--primary)';
            moduleInput.placeholder = 'Module Name (for Tabs - e.g., CRM, Billing)';
            moduleInput.value = item.module || '';
            moduleInput.oninput = (e) => {
                galleryArray[idx].module = e.target.value;
                updateHiddenInput();
            };
            moduleGroup.appendChild(moduleInput);

            // Title Input
            const titleGroup = document.createElement('div');
            titleGroup.className = 'mb-2';
            const titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.className = 'form-control'; // simplified class
            titleInput.placeholder = 'Feature Title (e.g., Dashboard Overview)';
            titleInput.value = item.title || '';
            titleInput.oninput = (e) => {
                galleryArray[idx].title = e.target.value;
                updateHiddenInput();
            };
            titleGroup.appendChild(titleInput);
            
            colInputs.appendChild(moduleGroup);
            colInputs.appendChild(titleGroup);
            const descGroup = document.createElement('div');
            const descInput = document.createElement('textarea');
            descInput.className = 'form-control';
            descInput.rows = 3;
            descInput.placeholder = 'Feature Description (HTML supported)';
            descInput.value = item.description || '';
            descInput.oninput = (e) => {
                galleryArray[idx].description = e.target.value;
                updateHiddenInput();
            };
            descGroup.appendChild(descInput);
            
            colInputs.appendChild(titleGroup);
            colInputs.appendChild(descGroup);

            // Col 3: Actions (1 column)
            const colAction = document.createElement('div');
            colAction.className = 'col-md-1 text-center';
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-outline-danger btn-sm';
            removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
            removeBtn.onclick = () => {
                galleryArray.splice(idx, 1);
                renderGallery();
                updateHiddenInput();
            };
            colAction.appendChild(removeBtn);

            gridRow.appendChild(colImg);
            gridRow.appendChild(colInputs);
            gridRow.appendChild(colAction);
            
            cardBody.appendChild(gridRow);
            row.appendChild(cardBody);
            galleryPreviews.appendChild(row);
        });
        
        updateHiddenInput();
    }

    function updateHiddenInput() {
        galleryUrlsInput.value = JSON.stringify(galleryArray);
    }

    // Add URL Button
    document.getElementById('add-gallery-url-btn').addEventListener('click', function() {
        const input = document.getElementById('gallery-url-input');
        const url = input.value.trim();
        if (url) {
            galleryArray.push({ url: url, module: '', title: '', description: '' });
            input.value = '';
            renderGallery();
        }
    });

    // ============================================
    // GALLERY HANDLERS
    // ============================================
    const galleryDropzone = document.getElementById('gallery-dropzone');
    const galleryFileInput = document.getElementById('gallery-file-input');
    const galleryProgressWrapper = document.getElementById('gallery-progress-wrapper');
    const galleryProgressBar = document.getElementById('gallery-progress');
    const galleryUploadStats = document.getElementById('gallery-upload-stats');

    // Note: Click handler removed - the "browse files" button handles this via inline onclick
    // galleryDropzone.addEventListener('click', () => galleryFileInput.click());
    
    galleryDropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        galleryDropzone.classList.add('border-primary');
    });
    
    galleryDropzone.addEventListener('dragleave', () => {
        galleryDropzone.classList.remove('border-primary');
    });
    
    galleryDropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        galleryDropzone.classList.remove('border-primary');
        handleGalleryFiles(e.dataTransfer.files);
    });


    galleryFileInput.addEventListener('change', (e) => {
        console.log('Gallery files selected:', e.target.files.length);
        if (e.target.files && e.target.files.length > 0) {
            handleGalleryFiles(e.target.files);
            // Reset file input so same file can be selected again
            e.target.value = '';
        }
    });

    function handleGalleryFiles(files) {
        console.log('handleGalleryFiles called with', files.length, 'files');
        if (!files.length) return;

        // Filter valid files
        const validFiles = Array.from(files).filter(file => {
            if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
                alert(`File "${file.name}" is skipped (not an image or video).`);
                return false;
            }
            return true;
        });

        console.log('Valid files:', validFiles.length);
        if (!validFiles.length) return;

        // UI Reset
        console.log('Starting upload, showing progress bar');
        galleryProgressWrapper.classList.remove('d-none');
        galleryProgressBar.style.width = '0%';
        galleryUploadStats.innerText = '0%';
        
        let completed = 0;
        let totalFiles = validFiles.length;
        let globalProgress = new Array(totalFiles).fill(0);

        validFiles.forEach((file, index) => {
            const formData = new FormData();
            formData.append('file', file);
            // CSRF Token
            const token = document.querySelector('meta[name="csrf-token"]').content;
            formData.append('_token', token);

            const xhr = new XMLHttpRequest();

            // Progress event
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    globalProgress[index] = percent;
                    
                    // Calculate average progress
                    const totalPercent = globalProgress.reduce((a, b) => a + b, 0) / totalFiles;
                    galleryProgressBar.style.width = totalPercent + '%';
                    galleryUploadStats.innerText = Math.round(totalPercent) + '%';
                }
            });

            xhr.addEventListener('load', () => {
                completed++;
                console.log(`File ${file.name} upload completed. Status: ${xhr.status}`);
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log('Upload response:', response);
                        if (response.success) {
                            // Add as rich object
                            galleryArray.push({ 
                                url: response.url, 
                                module: '',
                                title: file.name.split('.').slice(0, -1).join('.').replace(/[-_]/g, ' '), 
                                description: '' 
                            });
                            console.log('Added to galleryArray. Total items:', galleryArray.length);
                        } else {
                            console.error('Upload failed for ' + file.name + ': ' + (response.message || 'Unknown error'));
                        }
                    } catch (e) {
                         console.error('Error parsing response for ' + file.name, e);
                    }
                } else {
                     console.error('Upload error for ' + file.name + ' Status: ' + xhr.status);
                }

                // Check if all finished
                if (completed === totalFiles) {
                    console.log('All files completed. Rendering gallery...');
                    setTimeout(() => {
                        galleryProgressWrapper.classList.add('d-none');
                        renderGallery();
                        console.log('Gallery rendered');
                    }, 500);
                }
            });

            xhr.addEventListener('error', () => {
                completed++;
                console.error('Network error during upload for ' + file.name);
                if (completed === totalFiles) {
                    setTimeout(() => {
                        galleryProgressWrapper.classList.add('d-none');
                        renderGallery();
                    }, 500);
                }
            });

            const uploadUrl = '{{ route("admin.products.upload-media") }}';
            console.log('Opening XHR to:', uploadUrl);
            xhr.open('POST', uploadUrl);
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            console.log('Sending file:', file.name, 'Size:', file.size, 'bytes');
            xhr.send(formData);
        });
    }

    // ============================================
    // COVER IMAGE HANDLERS
    // ============================================
    const coverDropzone = document.getElementById('cover-dropzone');
    const coverFileInput = document.getElementById('cover-file-input');
    const coverPreview = document.getElementById('cover-preview');
    const coverPreviewContent = document.getElementById('cover-preview-content');
    const coverInput = document.getElementById('cover_image_url');
    const coverProgressWrapper = document.getElementById('cover-progress-wrapper');
    const coverProgress = document.getElementById('cover-progress');

    // Initialize cover image if exists from old input
    const oldCoverImage = @json(old('cover_image_url', ''));
    if (oldCoverImage && oldCoverImage.trim() !== '') {
        // coverInput.value is already set by Blade in the input field
        updateCoverPreview(oldCoverImage);
    }
    
    // Update preview button handler
    document.getElementById('update-cover-btn').addEventListener('click', function() {
        const url = coverInput.value.trim();
        if (url) {
            updateCoverPreview(url);
        } else {
            removeCover();
        }
    });

    // Also update on blur
    coverInput.addEventListener('blur', function() {
        const url = this.value.trim();
        if (url) {
            updateCoverPreview(url);
        }
    });

    function updateCoverPreview(url) {
        coverDropzone.style.display = 'none';
        coverPreviewContent.innerHTML = '';
        coverPreviewContent.appendChild(createMediaPreview(url, 'cover'));
        coverPreview.classList.remove('d-none');
    }

    // Expose removeCover to window scope
    window.removeCover = function() {
        const coverDropzone = document.getElementById('cover-dropzone');
        const coverPreview = document.getElementById('cover-preview');
        const coverInput = document.getElementById('cover_image_url');
        
        coverDropzone.style.display = 'block';
        coverPreview.classList.add('d-none');
        coverInput.value = '';
        document.getElementById('cover-preview-content').innerHTML = '';
        coverInput.value = '';
    };

    function uploadCoverFile(file) {
        if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
            alert('Please upload an image or video file');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        coverProgressWrapper.classList.remove('d-none');
        coverProgress.textContent = '0%';
        coverProgress.style.width = '0%';

        const xhr = new XMLHttpRequest();
        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                coverProgress.style.width = percentComplete + '%';
                coverProgress.textContent = Math.round(percentComplete) + '%';
            }
        });

        xhr.addEventListener('load', () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    coverInput.value = response.url;
                    updateCoverPreview(response.url);
                    coverProgressWrapper.classList.add('d-none');
                } else {
                    alert('Upload failed: ' + response.message);
                    coverProgressWrapper.classList.add('d-none');
                }
            } else {
                alert('Upload error. Status: ' + xhr.status);
                coverProgressWrapper.classList.add('d-none');
            }
        });

        xhr.addEventListener('error', () => {
            alert('Network error during upload');
            coverProgressWrapper.classList.add('d-none');
        });

        xhr.open('POST', '{{ route("admin.products.upload-media") }}');
        xhr.send(formData);
    }

    // Drag-drop for cover
    coverDropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        coverDropzone.classList.add('active');
    });

    coverDropzone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        coverDropzone.classList.remove('active');
    });

    coverDropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        coverDropzone.classList.remove('active');
        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length) {
            uploadCoverFile(e.dataTransfer.files[0]);
        }
    });

    coverFileInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            uploadCoverFile(e.target.files[0]);
        }
    });

});
</script>

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
        const editors = ['#full_description', '#changelog', '#license_terms'];
        editors.forEach(selector => {
            const element = document.querySelector(selector);
            if (element) {
                ClassicEditor.create(element, {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: { items: ['heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|', 'undo', 'redo'] }
                }).catch(error => { console.error(error); });
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* CKEditor Custom Styling */
    .ck-editor__editable_current { min-height: 400px; }
    .ck.ck-editor__main>.ck-editor__editable { background: #fff; min-height: 400px; border-radius: 0 0 12px 12px !important; }
    body.dark-mode .ck.ck-editor__main>.ck-editor__editable { background: var(--dark-bg); color: var(--dark-text); border-color: var(--dark-border); }
    body.dark-mode .ck.ck-toolbar { background: var(--dark-card) !important; border-color: var(--dark-border) !important; border-radius: 12px 12px 0 0 !important; }
    body.dark-mode .ck.ck-toolbar__items .ck-button { color: var(--dark-text) !important; }
    body.dark-mode .ck.ck-toolbar__items .ck-button:hover { background: var(--dark-bg) !important; }
    body.dark-mode .ck.ck-button.ck-on { background: var(--primary) !important; }

    .form-label.required::after { content: ' *'; color: #dc3545; }
.form-label.fw-600 { font-weight: 600; color: #212529; }

/* Media Dropzone Styling */
.media-dropzone {
    transition: all 0.3s ease;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    background-color: #f8f9fa;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.media-dropzone::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.02) 0%, transparent 100%);
    pointer-events: none;
}

.media-dropzone:hover {
    border-color: #007bff;
    background-color: #e7f1ff;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.media-dropzone:hover i {
    color: #0056b3;
    transform: scale(1.15);
}

.media-dropzone i {
    transition: all 0.3s ease;
    color: #6c757d;
}

.media-dropzone.active {
    border-color: #007bff;
    background-color: #e7f1ff;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.fw-500 {
    font-weight: 500;
    color: #212529;
}

.media-dropzone p {
    margin: 0;
    color: #495057;
    font-size: 15px;
    line-height: 1.5;
}

.media-dropzone small {
    color: #6c757d;
    font-size: 12px;
}

.text-primary {
    color: #007bff !important;
}

.text-muted {
    color: #6c757d !important;
}

/* Gallery Items Container - Rich Card Layout */
.gallery-items-container {
    display: flex;
    flex-direction: column;
    gap: 0;
    padding: 0;
    min-height: 50px;
}

/* Keep old grid styles for backward compatibility if needed */
.gallery-items-container.grid-mode {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 15px;
    padding: 10px 0;
}

/* Gallery Item Styling */
.gallery-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
}

.gallery-item {
    position: relative;
    width: 100%;
    height: 100%;
    border: 1px solid #e3e6f0;
    border-radius: 6px;
    overflow: hidden;
    background: #f8f9fa;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1; /* Lower z-index than button */
}

.gallery-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    border-color: #007bff;
}

.gallery-item img,
.gallery-item video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gallery-item iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Gallery Remove Button */
.gallery-remove-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 24px;
    height: 24px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #dc3545;
    border: 2px solid white;
    border-radius: 50%;
    font-size: 10px;
    color: white;
    opacity: 1;
    transition: all 0.2s ease;
    z-index: 100;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.gallery-wrapper:hover .gallery-remove-btn {
    transform: scale(1.1);
}

.gallery-remove-btn:hover {
    background-color: #bd2130;
    transform: scale(1.2) !important;
}

.gallery-remove-btn:hover {
    background-color: #dc3545;
    transform: scale(1.1);
}

/* Progress Bar Styling */
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
    transition: width 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 500;
    font-size: 13px;
}

/* Media Preview Styling */
#cover-preview-content {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background: #f8f9fa;
    max-width: 100%;
}

#cover-preview-content img,
#cover-preview-content video {
    width: 100%;
    max-height: 300px;
    object-fit: contain;
    display: block;
    border-radius: 6px;
}

#cover-preview-content iframe {
    width: 100%;
    height: 300px;
    border: none;
    border-radius: 6px;
}

/* Remove Button Styling */
.btn-outline-danger {
    transition: all 0.2s ease;
    border-width: 1px;
    font-size: 13px;
}

.btn-outline-danger:hover {
    transform: scale(1.05);
}

/* Media Card */
.card {
    border: 1px solid #e3e6f0;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    border-radius: 8px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e3e6f0;
    border-radius: 8px 8px 0 0;
}

.card-title {
    color: #212529;
    font-weight: 600;
}

/* Button Link Styling */
.btn-link {
    font-weight: 500;
    text-decoration: none;
    color: #007bff;
    transition: all 0.2s ease;
    font-size: 14px;
}

.btn-link:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Spacing utilities */
.mb-5 { margin-bottom: 2rem; }
.mb-4 { margin-bottom: 1.5rem; }
.mb-3 { margin-bottom: 1rem; }
.mb-2 { margin-bottom: 0.5rem; }
.gap-2 { gap: 0.5rem; }

/* Tech Stack Tags Styling */
#tech-stack-tags .badge {
    font-size: 0.85rem;
    padding: 0.35em 0.65em 0.35em 0.9em;
    display: inline-flex;
    align-items: center;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

#tech-stack-tags .tag-remove {
    background: transparent;
    border: none;
    color: white;
    font-size: 1.2em;
    line-height: 1;
    padding: 0 0.2em 0 0.4em;
    cursor: pointer;
    opacity: 0.8;
    margin-left: 0.3rem;
}

#tech-stack-tags .tag-remove:hover {
    opacity: 1;
}

#tech-stack-tags input[type="hidden"] {
    display: none;
}

/* Alert styling */
.alert.alert-danger {
    border-left: 4px solid #dc3545;
    background-color: #f8d7da;
}

.alert-heading {
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .gallery-items-container {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }
    
    .gallery-wrapper {
        aspect-ratio: 1;
    }
}
</style>
@endpush