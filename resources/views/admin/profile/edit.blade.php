<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { min-height: 100vh; display: flex; flex-direction: row; }
    .sidebar { height: 100vh; position: fixed; top: 0; left: 0; width: 220px; background-color: #343a40; padding-top: 60px; }
    .sidebar a { color: #fff; display: block; padding: 12px; text-decoration: none; }
    .sidebar a:hover, .sidebar a.active { background-color: #495057; }
    .main-content { margin-left: 220px; flex: 1; padding: 20px; }
  </style>
</head>
<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <h4 class="text-center text-white">Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.shop.index') }}">🛒 Shop Product</a>
    <a href="{{ route('admin.category.index') }}">📂 Category</a>
    <a href="{{ route('admin.brand.index') }}">🏷 Brand</a>
    <a href="{{ route('admin.pages.index') }}">📄 Pages</a>
    <a href="{{ route('admin.user.index') }}">👤 Users</a>
    <a href="{{ route('admin.profile.index') }}" class="active">⚙️ Profile</a>
  
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button type="submit" class="btn btn-outline-danger btn-sm w-100">🚪 Logout</button>
    </form>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
      <h2>Profile Edit</h2>

      <form action="{{ route('admin.profile.update') }}" method="POST" class="w-50">
          @csrf
          <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
          </div>
          <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
          </div>
          <button type="submit" class="btn btn-success">💾 Save</button>
          <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">↩️ Back</a>
      </form>
  </div>

</body>
</html>
