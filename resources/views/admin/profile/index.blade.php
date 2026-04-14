<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profile - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body { min-height: 100vh; display: flex; flex-direction: row; }
    .sidebar { height: 100vh; position: fixed; top: 0; left: 0; width: 220px; background-color: #343a40; padding-top: 60px; }
    .sidebar a { color: #fff; display: block; padding: 12px; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background-color: #495057; }
    .main-content { margin-left: 220px; flex: 1; }
    .profile-card { border-left: 4px solid #007bff; }
  </style>
</head>
<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <h4 class="text-center text-white">Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.shop.index') }}">🛒 Shop Product</a>
    <a href="{{ route('admin.category.index') }}">📂 Category</a>
    <a href="{{ route('admin.user.index') }}">👤 My Account</a>
    <a href="{{ route('admin.profile.index') }}" class="active">⚙️ Profile</a>
   
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button type="submit" class="btn btn-outline-danger btn-sm w-100">🚪 Logout</button>
    </form>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
    <div class="container-fluid py-4">

      {{-- Alert Messages --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          {{ session('info') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- Page Header --}}
      <div class="row mb-4">
        <div class="col-md-12">
          <h1 class="display-6 fw-bold">👤 Profile</h1>
          <p class="text-muted">View your profile information</p>
        </div>
      </div>

      {{-- Profile Information --}}
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card profile-card">
            <div class="card-header bg-light">
              <h5 class="mb-0">📋 Profile Information</h5>
            </div>
            <div class="card-body">
              <div class="text-center mb-4">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 80px; height: 80px;">
                  <i class="fas fa-user fa-2x text-white"></i>
                </div>
              </div>
              
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label fw-bold">Full Name</label>
                  <div class="form-control bg-light" style="cursor: not-allowed;">
                    {{ $user->name }}
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label fw-bold">Email Address</label>
                  <div class="form-control bg-light" style="cursor: not-allowed;">
                    {{ $user->email }}
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label fw-bold">Role</label>
                  <div class="form-control bg-light" style="cursor: not-allowed;">
                    <span class="badge bg-success">{{ ucfirst($user->role) }}</span>
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label fw-bold">Account Created</label>
                  <div class="form-control bg-light" style="cursor: not-allowed;">
                    {{ $user->created_at->format('M d, Y \a\t H:i') }}
                  </div>
                </div>
              </div>

              <div class="alert alert-info mt-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> Profile information is read-only and cannot be edited. 
                To update your account details, please use the <a href="{{ route('admin.user.index') }}" class="alert-link">My Account</a> section.
              </div>

              <div class="text-center mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">
                  <i class="fas fa-edit me-2"></i>Edit Account Details
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">
                  <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
