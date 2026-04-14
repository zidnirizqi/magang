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
    <a href="{{ route('admin.user.index') }}">👤 My Account</a>
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
                <label for="name" class="form-label">Product Name *</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Enter product name" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="category_id" class="form-label">Category *</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                  <option value="">Select Category</option>
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
              <div class="col-md-6">
                <label for="price" class="form-label">Price (Rp) *</label>
                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                       value="{{ old('price') }}" placeholder="0" min="0" step="1000" required>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="stock" class="form-label">Stock Quantity *</label>
                <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" 
                       value="{{ old('stock') }}" placeholder="0" min="0" required>
                @error('stock')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="status" class="form-label">Status *</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                  <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                       accept="image/jpeg,image/png,image/jpg,image/gif">
                <div class="form-text">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</div>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="4" placeholder="Enter product description...">{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-12">
                <div class="d-flex justify-content-between">
                  <div class="text-muted">
                    <small>* Required fields</small>
                  </div>
                  <div>
                    <a href="{{ route('admin.shop.index') }}" class="btn btn-secondary me-2">
                      <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save me-2"></i>Save Product
                    </button>
                  </div>
                </div>
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
