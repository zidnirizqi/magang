<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Shop Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      flex-direction: row;
    }
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 220px;
      background-color: #343a40;
      padding-top: 60px;
    }
    .sidebar a {
      color: #fff;
      display: block;
      padding: 12px;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #495057;
    }
    .main-content {
      margin-left: 220px;
      flex: 1;
    }
    header {
      background: #f8f9fa;
      padding: 10px 20px;
      border-bottom: 1px solid #ddd;
    }
    .stats-card {
      transition: transform 0.2s;
    }
    .stats-card:hover {
      transform: translateY(-5px);
    }
    .product-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
    }
    .status-badge {
      font-size: 0.75rem;
    }
  </style>
</head>
<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <h4 class="text-center text-white">Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.shop.index') }}" class="active">🛒 Shop Product</a>
    <a href="{{ route('admin.category.index') }}">📂 Category</a>
    <a href="{{ route('admin.user.index') }}">👤 Users</a>
    <a href="{{ route('admin.profile.index') }}">⚙️ Profile</a>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button type="submit" class="btn btn-outline-danger btn-sm w-100">🚪 Logout</button>
    </form>
  </div>

  {{-- Main Content --}}
  <div class="main-content">

    {{-- Header --}}

    <div class="container-fluid py-4">

      {{-- Alert session --}}
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Page Header --}}
      <div class="row mb-4">
        <div class="col-md-8">
          <h1 class="display-6 fw-bold">🛒 Shop Products</h1>
          <p class="text-muted">Manage your product inventory and stock</p>
        </div>
        <div class="col-md-4 text-end">
          <a href="{{ route('admin.shop.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Product
          </a>
        </div>
      </div>

      {{-- Stats Cards --}}
      <div class="row mb-4">
        <div class="col-md-3 mb-3">
          <div class="card bg-primary text-white stats-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="card-title">Total Products</h6>
                  <h2 class="mb-0">{{ $products->total() ?? 0 }}</h2>
                </div>
                <div class="align-self-center">
                  <i class="fas fa-box fa-2x opacity-75"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <div class="col-md-3 mb-3">
          <div class="card bg-success text-white stats-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="card-title">Active Products</h6>
                  <h2 class="mb-0">{{ \App\Models\Product::where('status', 'active')->count() }}</h2>
                </div>
                <div class="align-self-center">
                  <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card bg-warning text-white stats-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="card-title">Low Stock</h6>
                  <h2 class="mb-0">{{ \App\Models\Product::where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</h2>
                </div>
                <div class="align-self-center">
                  <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 mb-3">
          <div class="card bg-danger text-white stats-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div>
                  <h6 class="card-title">Out of Stock</h6>
                  <h2 class="mb-0">{{ \App\Models\Product::where('stock', 0)->count() }}</h2>
                </div>
                <div class="align-self-center">
                  <i class="fas fa-times-circle fa-2x opacity-75"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Filters --}}
      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" action="{{ route('admin.shop.index') }}" class="row g-3">
            <div class="col-md-4">
              <label for="search" class="form-label">Search Products</label>
              <div class="input-group">
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            
            <div class="col-md-3">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" id="category" name="category">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
            </div>
            
            <div class="col-md-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="all">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
            
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-filter me-2"></i>Filter
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      {{-- Products Table --}}
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="mb-0">📋 Products List</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Product Details</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($products as $product)
                  <tr>
                    <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                    <td>
                      <img src="{{ $product->image_url ?? 'https://via.placeholder.com/60x60/6c757d/FFFFFF?text=No+Image' }}" 
                           alt="{{ $product->name }}" 
                           class="product-img">
                    </td>
                    <td>
                      <div>
                        <strong class="text-dark">{{ $product->name }}</strong><br>
                        <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small><br>
                        @if($product->description)
                          <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                        @endif
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-info text-white">{{ $product->category->name ?? 'No Category' }}</span>
                    </td>
                    <td>
                      <strong class="text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                      @if($product->stock == 0)
                        <span class="badge bg-danger status-badge">Out of Stock</span>
                      @elseif($product->stock <= 10)
                        <span class="badge bg-warning status-badge">{{ $product->stock }} items</span>
                      @else
                        <span class="badge bg-success status-badge">{{ $product->stock }} items</span>
                      @endif
                    </td>
                    <td>
                      <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" 
                               type="checkbox" 
                               data-product-id="{{ $product->id }}"
                               {{ $product->status === 'active' ? 'checked' : '' }}>
                        <label class="form-check-label">
                          <small class="status-text-{{ $product->id }}">
                            {{ ucfirst($product->status) }}
                          </small>
                        </label>
                      </div>
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.shop.show', $product) }}" 
                           class="btn btn-info btn-sm" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.shop.edit', $product) }}" 
                           class="btn btn-warning btn-sm" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-danger btn-sm" 
                                title="Delete"
                                onclick="deleteProduct({{ $product->id }})">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center py-5">
                      <div class="text-muted">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <h5>No products found</h5>
                        <p>Start by adding your first product to the shop.</p>
                        <a href="{{ route('admin.shop.create') }}" class="btn btn-primary">
                          <i class="fas fa-plus me-2"></i>Add Your First Product
                        </a>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
              {{ $products->withQueryString()->links() }}
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>

  {{-- Delete Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">🗑️ Delete Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form id="deleteForm" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-trash me-2"></i>Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Toast Notification --}}
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert">
      <div class="toast-header">
        <i class="fas fa-bell me-2 text-primary"></i>
        <strong class="me-auto">Notification</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
      </div>
      <div class="toast-body">
        <!-- Message will be inserted here -->
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle Status
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
      toggle.addEventListener('change', function() {
        const productId = this.getAttribute('data-product-id');
        const statusText = document.querySelector('.status-text-' + productId);
        
        fetch(`/admin/shop/${productId}/toggle-status`, {
          method: 'PATCH',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
          },
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            statusText.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            
            // Show toast notification
            const toastEl = document.getElementById('liveToast');
            const toast = new bootstrap.Toast(toastEl);
            document.querySelector('.toast-body').textContent = data.message;
            toast.show();
          }
        })
        .catch(error => {
          console.error('Error:', error);
          this.checked = !this.checked; // Revert toggle
        });
      });
    });

    // Delete Product
    function deleteProduct(productId) {
      document.getElementById('deleteForm').action = `/admin/shop/${productId}`;
      const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
      modal.show();
    }
  </script>

</body>
</html>