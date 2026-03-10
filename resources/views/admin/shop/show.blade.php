<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $product->name }} - Product Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .product-image {
      max-width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 8px;
    }
    .info-card {
      border-left: 4px solid #007bff;
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
    <a href="{{ route('admin.brand.index') }}">🏷 Brand</a>
    <a href="{{ route('admin.pages.index') }}">📄 Pages</a>
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
    <header class="d-flex justify-content-between align-items-center">
      <a href="{{ url('/') }}" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="https://bajo.jumbomark.com/labels/JID2021078022" alt="Logo" width="150">
      </a>
      <span class="fw-bold">Welcome, {{ auth()->user()->name }}</span>
    </header>

    <div class="container-fluid py-4">

      {{-- Page Header --}}
      <div class="row mb-4">
        <div class="col-md-8">
          <h1 class="display-6 fw-bold">👁️ Product Detail</h1>
          <p class="text-muted">View product information</p>
        </div>
        <div class="col-md-4 text-end">
          <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
          </a>
          <a href="{{ route('admin.shop.edit', $product) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
          </a>
        </div>
      </div>

      <div class="row">
        {{-- Product Image --}}
        <div class="col-md-5">
          <div class="card">
            <div class="card-body text-center">
              <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
            </div>
          </div>
        </div>
        
        {{-- Product Information --}}
        <div class="col-md-7">
          <div class="card info-card">
            <div class="card-header">
              <h4 class="mb-0">{{ $product->name }}</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <h6 class="text-muted">Price</h6>
                  <h3 class="text-success fw-bold">{{ $product->formatted_price }}</h3>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted">Stock</h6>
                  <h4>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                      {{ $product->stock }} units
                    </span>
                  </h4>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <h6 class="text-muted">Category</h6>
                  <span class="badge bg-secondary fs-6">{{ $product->category->name }}</span>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted">Status</h6>
                  <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-danger' }} fs-6">
                    {{ ucfirst($product->status) }}
                  </span>
                </div>
              </div>

              @if($product->description)
                <div class="mb-3">
                  <h6 class="text-muted">Description</h6>
                  <p class="text-dark">{{ $product->description }}</p>
                </div>
              @endif

              <div class="row mb-3">
                <div class="col-md-6">
                  <h6 class="text-muted">Created Date</h6>
                  <p class="mb-0">{{ $product->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted">Last Updated</h6>
                  <p class="mb-0">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Action Buttons --}}
          <div class="card mt-3">
            <div class="card-body">
              <div class="d-flex gap-2">
                <a href="{{ route('admin.shop.edit', $product) }}" class="btn btn-warning">
                  <i class="fas fa-edit me-2"></i>Edit Product
                </a>
                
                <form action="{{ route('admin.shop.toggleStatus', $product) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PATCH')
                  <button type="submit" class="btn {{ $product->status == 'active' ? 'btn-secondary' : 'btn-success' }}">
                    <i class="fas {{ $product->status == 'active' ? 'fa-pause' : 'fa-play' }} me-2"></i>
                    {{ $product->status == 'active' ? 'Deactivate' : 'Activate' }}
                  </button>
                </form>

                <form action="{{ route('admin.shop.destroy', $product) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Delete Product
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Additional Info Cards --}}
      <div class="row mt-4">
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="fas fa-eye fa-2x text-primary mb-2"></i>
              <h5>Views</h5>
              <p class="text-muted">Feature coming soon</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
              <h5>Orders</h5>
              <p class="text-muted">Feature coming soon</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <i class="fas fa-star fa-2x text-warning mb-2"></i>
              <h5>Reviews</h5>
              <p class="text-muted">Feature coming soon</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>