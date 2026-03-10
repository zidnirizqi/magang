<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Profile</title>
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
      <h2>My Profile</h2>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <table class="table table-bordered w-50">
          <tr><th>Name</th><td>{{ $user->name }}</td></tr>
          <tr><th>Email</th><td>{{ $user->email }}</td></tr>
      </table>

      <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">✏️ Edit Profile</a>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary">↩️ Back</a>
  </div>

</body>
</html>
