@extends('admin.layouts.app')

@section('title', 'Email Templates | CodeCraft Studio')
@section('page-title', 'Email Templates')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h1>Email Templates</h1>
            <p>Manage reusable templates for transactional and marketing emails</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.emails.templates.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Create Template
            </a>
        </div>
    </div>

    <div class="card" style="margin-bottom: 24px;">
        <div class="card-body">
            <div class="tabs-container">
                <a href="{{ route('admin.emails.index') }}" class="tab-link">Email History</a>
                <a href="{{ route('admin.emails.templates') }}" class="tab-link active">Email Templates</a>
            </div>
        </div>
    </div>

    <div class="templates-grid">
        @forelse($templates as $template)
            <div class="card template-card">
                <div class="card-body">
                    <div class="template-icon">
                        <i class="fas fa-file-code"></i>
                    </div>
                    <div class="template-header">
                        <div class="template-badge">{{ ucfirst($template->category) }}</div>
                        @if($template->is_active)
                            <span class="status-badge status-published">Active</span>
                        @else
                            <span class="status-badge">Inactive</span>
                        @endif
                    </div>
                    <h3 class="template-name">{{ $template->name }}</h3>
                    <p class="template-key">Key: <code>{{ $template->template_key }}</code></p>
                    <p class="template-subject"><span class="label">Subject:</span> {{ $template->subject }}</p>

                    <div class="template-footer">
                        <div class="template-actions">
                            <a href="{{ route('admin.emails.templates.edit', $template->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.emails.templates.delete', $template->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this template?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card w-100">
                <div class="card-body empty-state">
                    <i class="fas fa-layer-group"></i>
                    <h3>No templates created yet</h3>
                    <p>Start by creating your first email template to automate your communications.</p>
                    <a href="{{ route('admin.emails.templates.create') }}" class="btn btn-primary mt-3">Create Template</a>
                </div>
            </div>
        @endforelse
    </div>

    <style>
        .tabs-container {
            display: flex;
            gap: 20px;
            border-bottom: 1px solid var(--light-border);
            padding-bottom: 10px;
        }

        .tab-link {
            text-decoration: none;
            color: var(--light-muted);
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .tab-link:hover {
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.05);
        }

        .tab-link.active {
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.1);
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }

        .template-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .template-icon {
            width: 48px;
            height: 48px;
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }

        .template-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .template-badge {
            font-size: 0.75rem;
            background: var(--bg-tertiary);
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .template-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .template-key {
            font-size: 0.875rem;
            color: var(--light-muted);
            margin-bottom: 12px;
        }

        .template-subject {
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .template-subject .label {
            font-weight: 600;
            color: var(--light-muted);
        }

        .template-footer {
            border-top: 1px solid var(--light-border);
            padding-top: 16px;
        }

        .template-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
    </style>
@endsection