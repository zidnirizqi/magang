<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Edit Admin User - {{ $user->name }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { min-height: 100vh; display: flex; flex-direction: row; }
    .sidebar { height: 100vh; position: fixed; top: 0; left: 0; width: 220px; background-color: #343a40; padding-top: 60px; }
    .sidebar a { color: #fff; display: block; padding: 12px; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background-color: #495057; }
    .main-content { margin-left: 220px; flex: 1; }
  </style>
</head>
<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <h4 class="text-center text-white">Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.shop.index') }}">🛒 Shop Product</a>
    <a href="{{ route('admin.category.index') }}">📂 Category</a>
    <a href="{{ route('admin.user.index') }}" class="active">👤 My Account</a>
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
          <h1 class="display-6 fw-bold">✏️ Edit My Account</h1>
          <p class="text-muted">Update your account information</p>
        </div>
        <div class="col-md-4 text-end">
          <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to My Account
          </a>
        </div>
      </div>

      {{-- User Form --}}
      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">📝 My Account Information</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email Address *</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                       placeholder="Leave blank to keep current password">
                <div class="form-text">Leave blank if you don't want to change the password</div>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <input type="text" id="role" class="form-control" value="Admin" readonly>
                <div class="form-text">Role cannot be changed</div>
              </div>
              <div class="col-12">
                <div class="alert alert-info">
                  <i class="fas fa-info-circle me-2"></i>
                  <strong>Account Info:</strong> Created on {{ $user->created_at->format('M d, Y \a\t H:i') }}
                  <span class="badge bg-primary ms-2">This is your account</span>
                </div>
              </div>
              <div class="col-12">
                <div class="d-flex justify-content-between">
                  <div class="text-muted">
                    <small>* Required fields</small>
                  </div>
                  <div>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary me-2">
                      <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save me-2"></i>Update My Account
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
