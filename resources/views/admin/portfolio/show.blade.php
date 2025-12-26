@extends('admin.layouts.app')

@section('title', 'View Project')

@section('content')
    <div class="page-header">
        <div class="page-title">
            <a href="{{ route('admin.portfolio.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to
                Portfolio</a>
            <h1>{{ $project->title }}</h1>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.portfolio.edit', $project) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Edit Project
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Project Overview</h3>
                </div>
                <div class="card-body">
                    <div class="project-details mb-4">
                        @if($project->challenge)
                            <div class="detail-section mb-4">
                                <h5 class="fw-bold"><i class="fas fa-bullseye text-primary me-2"></i> The Challenge</h5>
                                <p>{{ $project->challenge }}</p>
                            </div>
                        @endif

                        @if($project->solution)
                            <div class="detail-section mb-4">
                                <h5 class="fw-bold"><i class="fas fa-lightbulb text-warning me-2"></i> The Solution</h5>
                                <p>{{ $project->solution }}</p>
                            </div>
                        @endif

                        @if($project->result)
                            <div class="detail-section mb-4">
                                <h5 class="fw-bold"><i class="fas fa-check-circle text-success me-2"></i> The Result</h5>
                                <p>{{ $project->result }}</p>
                            </div>
                        @endif
                    </div>

                    <h5 class="fw-bold mb-3">Project Gallery</h5>
                    <div class="gallery-preview-grid">
                        @if($project->images)
                            @foreach($project->images as $image)
                                <div class="gallery-preview-item">
                                    <img src="{{ $image }}" class="img-fluid rounded shadow-sm">
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No gallery images uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="project-info-sidebar">
                        <div class="info-item mb-3">
                            <span class="label text-muted d-block small text-uppercase">Client</span>
                            <span class="value fw-bold">{{ $project->client_name ?: 'N/A' }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <span class="label text-muted d-block small text-uppercase">Project Type</span>
                            <span class="value fw-bold">{{ $project->project_type }}</span>
                        </div>
                        <div class="info-item mb-3">
                            <span class="label text-muted d-block small text-uppercase">Status</span>
                            @if($project->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </div>
                        <div class="info-item mb-3">
                            <span class="label text-muted d-block small text-uppercase">Tech Stack</span>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @if($project->tech_stack)
                                    @foreach($project->tech_stack as $tech)
                                        <span class="badge bg-light text-dark border">{{ $tech }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($project->cover_image_url)
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Cover Image</h3>
                    </div>
                    <div class="card-body p-0">
                        <img src="{{ $project->cover_image_url }}" class="img-fluid w-100 h-auto"
                            style="border-radius: 0 0 12px 12px;">
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3>Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($project->project_url)
                            <a href="{{ $project->project_url }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt me-2"></i> Visit Live Site
                            </a>
                        @endif
                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" class="btn btn-outline-dark">
                                <i class="fab fa-github me-2"></i> View Code
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        .gallery-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
        }
    </style>
@endsection