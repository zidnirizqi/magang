@extends('layouts.app')

@section('title', 'Products - ShopApp')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">All Products</h2>
            <p class="text-muted">Discover our complete collection of quality products</p>
        </div>
        <div class="col-md-6 text-md-end">
            <span class="text-muted">Showing {{ $products->count() }} of {{ $products->total() }} products</span>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('products') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search Products</label>
                        <div class="input-group">
                            <input type="text" class="form-control search-bar" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by name or description...">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" onchange="document.getElementById('filterForm').submit();">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Latest</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary d-block">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-6">
            <div class="card product-card h-100">
                <div class="position-relative">
                    <div class="product-image">
                        @switch($product->category->name ?? 'default')
                            @case('Electronics')
                                <i class="fas fa-laptop"></i>
                                @break
                            @case('Smartphones')
                                <i class="fas fa-mobile-alt"></i>
                                @break
                            @case('Clothing')
                                <i class="fas fa-tshirt"></i>
                                @break
                            @case('Books')
                                <i class="fas fa-book"></i>
                                @break
                            @case('Sports')
                                <i class="fas fa-football-ball"></i>
                                @break
                            @default
                                <i class="fas fa-box"></i>
                        @endswitch
                    </div>
                    <span class="badge-stock {{ $product->stock > 0 ? '' : 'out-of-stock' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-secondary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <h6 class="card-title fw-bold">{{ $product->name }}</h6>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="price-tag">{{ $product->formatted_price }}</span>
                            <small class="text-muted">Stock: {{ $product->stock }}</small>
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @else
    <!-- No Products Found -->
    <div class="text-center py-5">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">No products found</h4>
        <p class="text-muted">Try adjusting your search criteria or browse all categories.</p>
        <a href="{{ route('products') }}" class="btn btn-primary">
            <i class="fas fa-th-large"></i> View All Products
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit search form on Enter key
    $('#search').on('keypress', function(e) {
        if (e.which == 13) {
            $('#filterForm').submit();
        }
    });
    
    // Add loading state to filter form
    $('#filterForm').on('submit', function() {
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i>');
    });
    
    // Product card hover effects
    $('.product-card').hover(function() {
        $(this).find('.btn').removeClass('btn-primary').addClass('btn-success');
    }, function() {
        $(this).find('.btn').removeClass('btn-success').addClass('btn-primary');
    });
});
</script>
@endpush