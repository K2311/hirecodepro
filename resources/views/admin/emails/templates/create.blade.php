@extends('admin.layouts.app')

@section('title', 'Create Email Template | CodeCraft Studio')
@section('page-title', 'Create Email Template')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <a href="{{ route('admin.emails.templates') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to
                Templates</a>
            <h1>Create New Email Template</h1>
        </div>
    </div>

    <form action="{{ route('admin.emails.templates.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Template Content</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label" for="subject">Email Subject</label>
                            <input type="text" name="subject" id="subject"
                                class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}"
                                required placeholder="e.g. Welcome to CodeCraft, @{{ $user_name }}!">
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="body_html">HTML Content</label>
                            <textarea name="body_html" id="body_html" rows="15"
                                class="form-control @error('body_html') is-invalid @enderror" required
                                placeholder="<h1>Hello @{{ $user_name }}</h1>...">{{ old('body_html') }}</textarea>
                            @error('body_html') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">You can use variables like <code>@{{ $name }}</code></small>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="body_text">Plain Text Version (Optional)</label>
                            <textarea name="body_text" id="body_text" rows="8"
                                class="form-control @error('body_text') is-invalid @enderror"
                                placeholder="Hello @{{ $user_name }}...">{{ old('body_text') }}</textarea>
                            @error('body_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Template Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label" for="name">Template Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                                placeholder="e.g. Welcome Email">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="template_key">Template Key (Unique ID)</label>
                            <input type="text" name="template_key" id="template_key"
                                class="form-control @error('template_key') is-invalid @enderror"
                                value="{{ old('template_key') }}" required placeholder="e.g. welcome_email">
                            @error('template_key') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Used to trigger this email via code.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="category">Category</label>
                            <select name="category" id="category"
                                class="form-select @error('category') is-invalid @enderror" required>
                                <option value="onboarding">Onboarding</option>
                                <option value="transactions">Transactions</option>
                                <option value="marketing">Marketing</option>
                                <option value="support">Support</option>
                                <option value="general" selected>General</option>
                            </select>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                checked>
                            <label class="form-check-label" for="is_active">Active Template</label>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-large">Save Template</button>
                            <a href="{{ route('admin.emails.templates') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Available Variables</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled small">
                            <li class="mb-2"><code>@{{ $user_full_name }}</code></li>
                            <li class="mb-2"><code>@{{ $order_id }}</code></li>
                            <li class="mb-2"><code>@{{ $product_name }}</code></li>
                            <li class="mb-2"><code>@{{ $app_name }}</code></li>
                            <li class="mb-2"><code>@{{ $support_url }}</code></li>
                        </ul>
                        <p class="small text-muted">You can add custom variables by passing them in the mailer.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .row {
            display: flex;
            gap: 24px;
        }

        .col-8 {
            flex: 2;
        }

        .col-4 {
            flex: 1;
        }

        .form-switch {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-input {
            width: 40px;
            height: 20px;
            cursor: pointer;
        }
    </style>
@endsection