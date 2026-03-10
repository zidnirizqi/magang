{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: flex; }
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
        .sidebar a:hover, 
        .sidebar a.active { 
            background-color: #495057; 
        }
        .main-content { 
            margin-left: 220px; 
            flex: 1; 
            padding: 20px; 
        }
        .product-img { 
            width: 60px; 
            height: 60px; 
            object-fit: cover; 
            border-radius: 8px; 
        }
        .status-badge { font-size: 0.75rem; }
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
        <h2>@yield('title')</h2>
        @yield('content')
    </div>
</body>
</html>
