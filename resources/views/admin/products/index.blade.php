@extends('admin.layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <i class="fas fa-box"></i>
            Products Management
        </h1>
        <p class="page-subtitle">Manage your code products, templates, and digital assets</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Product
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4 filter-card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-filter"></i>
            Filters & Search
        </h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex flex-wrap align-items-end filter-form">
            <div class="filter-item">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ request('search') }}" placeholder="Search products..." style="min-width:260px;">
            </div>

            <div class="filter-item">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" style="width:150px;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <div class="filter-item">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" style="width:220px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item">
                <label for="featured" class="form-label">Featured</label>
                <select class="form-select" id="featured" name="featured" style="width:140px;">
                    <option value="">All</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                </select>
            </div>

            <div class="filter-actions ms-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Actions -->
@if($products->count() > 0)
<div class="card mb-4">
    <div class="card-body">
        <form id="bulkActionForm" method="POST" action="{{ route('admin.products.bulk-action') }}">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                        <label class="form-check-label" for="selectAll">
                            Select All
                        </label>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group" role="group">
                        <button type="submit" name="action" value="activate" class="btn btn-success btn-sm bulk-action-btn" disabled>
                            <i class="fas fa-play"></i> Activate
                        </button>
                        <button type="submit" name="action" value="deactivate" class="btn btn-warning btn-sm bulk-action-btn" disabled>
                            <i class="fas fa-pause"></i> Deactivate
                        </button>
                        <button type="submit" name="action" value="feature" class="btn btn-info btn-sm bulk-action-btn" disabled>
                            <i class="fas fa-star"></i> Feature
                        </button>
                        <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm bulk-action-btn" disabled>
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Products Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list"></i>
            Products ({{ $products->total() }})
        </h5>
    </div>
    <div class="card-body p-0">
        @if($products->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40">
                            <input type="checkbox" class="form-check-input" id="selectAllHeader">
                        </th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Sales</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td data-label="Select">
                            <input type="checkbox" class="form-check-input product-checkbox"
                                   name="products[]" value="{{ $product->id }}" form="bulkActionForm">
                        </td>
                        <td data-label="Product">
                            <div class="d-flex align-items-center">
                                @if($product->cover_image_url)
                                    <img src="{{ $product->cover_image_url }}" alt="{{ $product->name }}"
                                         class="rounded me-3" width="40" height="40" style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px;">
                                        <i class="fas fa-box text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($product->short_description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td data-label="Category">
                            @if($product->category)
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td data-label="Type">
                            <span class="badge bg-info">{{ ucfirst($product->product_type) }}</span>
                        </td>
                        <td data-label="Price">
                            <div>
                                <strong>${{ number_format($product->current_price, 2) }}</strong>
                                @if($product->is_on_sale && $product->sale_price)
                                    <br><small class="text-muted"><s>${{ number_format($product->base_price, 2) }}</s></small>
                                @endif
                            </div>
                        </td>
                        <td data-label="Status">
                            @switch($product->status)
                                @case('active')
                                    <span class="badge bg-success">Active</span>
                                    @break
                                @case('inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                    @break
                                @case('draft')
                                    <span class="badge bg-warning">Draft</span>
                                    @break
                            @endswitch
                        </td>
                        <td data-label="Featured">
                            <button type="button"
                                    class="btn btn-sm {{ $product->is_featured ? 'btn-warning' : 'btn-outline-warning' }} toggle-featured"
                                    data-url="{{ route('admin.products.toggle-featured', $product) }}"
                                    data-id="{{ $product->id }}">
                                <i class="fas fa-star"></i>
                            </button>
                        </td>
                        <td data-label="Sales">
                            <span class="badge bg-primary">{{ $product->purchase_count ?? 0 }}</span>
                        </td>
                        <td data-label="Created">
                            <small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small>
                        </td>
                        <td data-label="Actions">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-product"
                                        data-url="{{ route('admin.products.destroy', $product) }}"
                                        data-name="{{ $product->name }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            {{ $products->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No products found</h5>
            <p class="text-muted">Get started by creating your first product.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add Your First Product
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkActionBtns = document.querySelectorAll('.bulk-action-btn');

    function updateBulkButtons() {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        const hasSelection = checkedBoxes.length > 0;

        bulkActionBtns.forEach(btn => {
            btn.disabled = !hasSelection;
        });
    }

    selectAllCheckbox?.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        // keep header checkbox in sync and clear indeterminate
        if (selectAllHeader) {
            selectAllHeader.checked = this.checked;
            selectAllHeader.indeterminate = false;
        }
        this.indeterminate = false;
        updateBulkButtons();
    });

    selectAllHeader?.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        // sync main selectAll and clear indeterminate
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = this.checked;
            selectAllCheckbox.indeterminate = false;
        }
        this.indeterminate = false;
        updateBulkButtons();
    });

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(productCheckboxes).some(cb => cb.checked);

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
            if (selectAllHeader) {
                selectAllHeader.checked = allChecked;
                selectAllHeader.indeterminate = someChecked && !allChecked;
            }

            updateBulkButtons();
        });
    });

    // Bulk action form handling: confirm deletes and prevent double submissions
    const bulkForm = document.getElementById('bulkActionForm');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            const formData = new FormData(this);
            const action = formData.get('action');
            const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;

            if (!checkedCount) {
                e.preventDefault();
                alert('Please select at least one product to perform this action.');
                return;
            }

            if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${checkedCount} product(s)? This action cannot be undone.`)) {
                    e.preventDefault();
                    return;
                }
            }

            // disable bulk buttons to avoid duplicate submissions
            bulkActionBtns.forEach(btn => btn.disabled = true);
        });
    }

    // Toggle Featured
    document.querySelectorAll('.toggle-featured').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url;
            const button = this;
            // prevent double clicks
            if (button.disabled) return;
            button.disabled = true;
            const originalHTML = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    button.classList.toggle('btn-warning', data.is_featured);
                    button.classList.toggle('btn-outline-warning', !data.is_featured);
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Action failed', 'error');
                }
            } catch (error) {
                showToast('An error occurred. Please try again.', 'error');
            } finally {
                button.disabled = false;
                button.innerHTML = originalHTML;
            }
        });
    });

    // Delete Product
    document.querySelectorAll('.delete-product').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url;
            const name = this.dataset.name;
            if (confirm(`Are you sure you want to delete "${name}"? This action cannot be undone.`)) {
                // disable button to prevent duplicate submits
                btn.disabled = true;

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">&times;</button>
        `;

        // Add to page
        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => toast.classList.add('show'), 100);

        // Auto hide
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 3000);

        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 0;
    z-index: 9999;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    border-left: 4px solid;
}

.toast.show {
    transform: translateX(0);
}

.toast-success {
    border-left-color: #10b981;
}

.toast-error {
    border-left-color: #ef4444;
}

.toast-info {
    border-left-color: #3b82f6;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
}

.toast-content i {
    font-size: 18px;
}

.toast-success .toast-content i {
    color: #10b981;
}

.toast-error .toast-content i {
    color: #ef4444;
}

.toast-info .toast-content i {
    color: #3b82f6;
}

.toast-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #6b7280;
    cursor: pointer;
    padding: 16px 20px 16px 0;
    margin-left: auto;
}

.toast-close:hover {
    color: #374151;
}
</style>
@endpush