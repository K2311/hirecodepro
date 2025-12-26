@extends('admin.layouts.app')

@section('title', 'Edit Blog Category | CodeCraft Studio')

@section('content')
    <div class="page-header mb-4">
        <div class="page-title">
            <h1 class="fw-bold">
                <a href="{{ route('admin.blog-categories.index') }}" class="text-muted decoration-none me-2"><i
                        class="fas fa-arrow-left"></i></a>
                Edit Category: {{ $category->name }}
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="premium-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.blog-categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Category
                                Name</label>
                            <input type="text" name="name" class="form-input-premium @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Slug</label>
                            <input type="text" name="slug" class="form-input-premium @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $category->slug) }}" required>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-uppercase fw-bold text-muted ls-1 mb-2">Description</label>
                            <textarea name="description" class="form-input-premium h-auto" rows="4"
                                placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                        </div>

                        <div class="form-check form-switch mb-4 d-flex align-items-center gap-3 ps-0">
                            <input class="form-check-input ms-0" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} id="statusSwitch"
                                style="width: 2.8rem; height: 1.4rem;">
                            <label class="form-check-label fw-bold text-dark" for="statusSwitch">Category is Active</label>
                        </div>

                        <hr class="opacity-10 my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold">Update
                                Category</button>
                            <a href="{{ route('admin.blog-categories.index') }}"
                                class="btn btn-outline-secondary rounded-pill px-4 py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        .form-input-premium {
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

        body.dark-mode .form-input-premium {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        .form-input-premium:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
    </style>
@endsection