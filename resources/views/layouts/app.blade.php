<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
    .sidebar a:hover {
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
    <a href="{{ route('admin.profile.index') }}">⚙️ Profile</a>
  
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
      @csrf
      <button type="submit" class="btn btn-outline-danger btn-sm w-100">🚪 Logout</button>
    </form>
  </div>

  {{-- Main Content --}}
  <div class="main-content">

    {{-- Header --}}
    <div class="container py-4">

      {{-- Alert session --}}
      @if (session('success'))
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      @endif

      {{-- Content akan diisi dengan @yield('content') --}}
      @yield('content')

    </div>
  </div>

</body>
</html>