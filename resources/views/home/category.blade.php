@extends('layouts.app')

@section('title', $category->name . ' - ShopApp')

@section('content')
<div class="container py-5">
    <!-- Category Header -->
    <div class="row mb-5">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center mb-3">
                <div class="category-icon me-3">
                    @switch($category->name)
                        @case('Electronics')
                            <i class="fas fa-laptop fa-3x text-primary"></i>
                            @break
                        @case('Clothing')
                            <i class="fas fa-tshirt fa-3x text-success"></i>
                            @break
                        @case('Books')
                            <i class="fas fa-book fa-3x text-info"></i>
                            @break
                        @case('Smartphones')
                            <i class="fas fa-mobile-alt fa-3x text-warning"></i>
                            @break
                        @case('Sports')
                            <i class="fas fa-football-ball fa-3x text-danger"></i>
                            @break
                        @default
                            <i class="fas fa-tag fa-3x text-secondary"></i>
                    @endswitch
                </div>
                <div>
                    <h1 class="fw-bold mb-2">{{ $category->name }}</h1>
                    <p class="text-muted mb-0">{{ $category->description }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="stats-card">
                <h3 class="text-primary">{{ $products->total() }}</h3>
                <p class="mb-0">Products Available</p>
            </div>
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
        {{ $products->links() }}
    </div>
    @else
    <!-- No Products Found -->
    <div class="text-center py-5">
        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">No products in this category</h4>
        <p class="text-muted">Check back later for new products in {{ $category->name }}!</p>
        <a href="{{ route('products') }}" class="btn btn-primary">
            <i class="fas fa-th-large"></i> Browse All Products
        </a>
    </div>
    @endif

    <!-- Category Navigation -->
    <div class="mt-5">
        <h4 class="fw-bold mb-3">Other Categories</h4>
        <div class="row g-3">
            @php
                $otherCategories = \App\Models\Category::active()
                    ->where('id', '!=', $category->id)
                    ->withCount(['products' => function($q) { 
                        $q->active()->where('stock', '>', 0); 
                    }])
                    ->having('products_count', '>', 0)
                    ->take(4)
                    ->get();
            @endphp
            
            @foreach($otherCategories as $otherCategory)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('category', $otherCategory->id) }}" class="text-decoration-none">
                    <div class="card border-0 bg-light text-center p-3 h-100 category-nav-card">
                        <div class="category-icon mb-2">
                            @switch($otherCategory->name)
                                @case('Electronics')
                                    <i class="fas fa-laptop fa-2x text-primary"></i>
                                    @break
                                @case('Clothing')
                                    <i class="fas fa-tshirt fa-2x text-success"></i>
                                    @break
                                @case('Books')
                                    <i class="fas fa-book fa-2x text-info"></i>
                                    @break
                                @case('Smartphones')
                                    <i class="fas fa-mobile-alt fa-2x text-warning"></i>
                                    @break
                                @case('Sports')
                                    <i class="fas fa-football-ball fa-2x text-danger"></i>
                                    @break
                                @default
                                    <i class="fas fa-tag fa-2x text-secondary"></i>
                            @endswitch
                        </div>
                        <h6 class="fw-bold text-dark">{{ $otherCategory->name }}</h6>
                        <small class="text-muted">{{ $otherCategory->products_count }} products</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.category-nav-card {
    transition: all 0.3s ease;
}

.category-nav-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.category-icon {
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .category-icon i {
        font-size: 2rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Add hover effects to product cards
    $('.product-card').hover(function() {
        $(this).find('.btn').removeClass('btn-primary').addClass('btn-success');
    }, function() {
        $(this).find('.btn').removeClass('btn-success').addClass('btn-primary');
    });
    
    // Add animation to category navigation cards
    $('.category-nav-card').hover(function() {
        $(this).addClass('bg-white shadow');
    }, function() {
        $(this).removeClass('bg-white shadow');
    });
});
</script>
@endpush