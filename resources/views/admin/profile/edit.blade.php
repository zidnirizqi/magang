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

      {{-- Page Header --}}
      <div class="row mb-4">
        <div class="col-md-12">
          <h1 class="display-6 fw-bold">⚠️ Profile Edit Not Available</h1>
          <p class="text-muted">Profile information cannot be edited from this page</p>
        </div>
      </div>

      {{-- Info Message --}}
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-body text-center py-5">
              <i class="fas fa-lock fa-4x text-muted mb-4"></i>
              <h4>Profile Editing Disabled</h4>
              <p class="text-muted mb-4">
                Profile information is read-only and cannot be edited from this section. 
                To update your account details, please use the My Account section.
              </p>
              <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary">
                  <i class="fas fa-edit me-2"></i>Go to My Account
                </a>
                <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left me-2"></i>Back to Profile
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
