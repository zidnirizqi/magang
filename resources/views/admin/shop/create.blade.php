<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { min-height: 100vh; display: flex; flex-direction: row; }
    .sidebar { height: 100vh; position: fixed; top: 0; left: 0; width: 220px; background-color: #343a40; padding-top: 60px; }
    .sidebar a { color: #fff; display: block; padding: 12px; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background-color: #495057; }
    .main-content { margin-left: 220px; flex: 1; }
    .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    .status-badge { font-size: 0.75rem; }
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
    <div class="container-fluid py-4">

      {{-- Success Message --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Page Header --}}
      <div class="row mb-4">
        <div class="col-md-8">
          <h1 class="display-6 fw-bold">➕ Add New Product</h1>
          <p class="text-muted">Fill the form below to add product</p>
        </div>
        <div class="col-md-4 text-end">
          <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
          </a>
        </div>
      </div>

      {{-- Product Form --}}
      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">📝 Product Information</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.shop.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="category" class="form-label">Category</label>
                <input type="text" 
                       class="form-control @error('category') is-invalid @enderror" 
                       id="category" 
                       name="category" 
                       value="{{ old('category', $product->category ?? '') }}" 
                       placeholder="Tulis kategori produk" required>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>              
              <div class="col-md-6">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
              </div>
              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save me-2"></i>Save Product
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
