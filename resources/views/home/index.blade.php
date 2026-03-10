@extends('layouts.app')

@section('title', 'ShopApp - Your Online Store')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to ShopApp</h1>
                <p class="lead mb-4">Discover amazing products at unbeatable prices. From electronics to fashion, we have everything you need.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag"></i> Shop Now
                    </a>
                    <a href="#featured" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-star"></i> Featured Products
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-stats">
                    <div class="row">
                        <div class="col-4">
                            <div class="stats-card">
                                <h3 class="text-primary">{{ $stats['total_products'] }}</h3>
                                <p class="mb-0">Products</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-card">
                                <h3 class="text-success">{{ $stats['total_categories'] }}</h3>
                                <p class="mb-0">Categories</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stats-card">
                                <h3 class="text-warning">{{ $stats['featured_count'] }}</h3>
                                <p class="mb-0">Featured</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Shop by Category</h2>
            <p class="text-muted">Browse our wide range of product categories</p>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('category', $category->id) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="category-icon mb-3">
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
                        <h5 class="fw-bold text-dark">{{ $category->name }}</h5>
                        <p class="text-muted mb-2">{{ $category->description }}</p>
                        <span class="badge bg-primary">{{ $category->products_count }} Products</span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Products</h2>
            <p class="text-muted">Check out our most popular and trending products</p>
        </div>
        
        @if($featuredProducts->count() > 0)
        <div class="row g-4">
            @foreach($featuredProducts as $product)
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
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">{{ $product->formatted_price }}</span>
                                <small class="text-muted">Stock: {{ $product->stock }}</small>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-th-large"></i> View All Products
            </a>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No products available</h4>
            <p class="text-muted">Check back later for new products!</p>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-2">Stay Updated!</h3>
                <p class="mb-0">Subscribe to our newsletter for the latest products and exclusive offers.</p>
            </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email">
                    <button class="btn btn-light" type="button">
                        <i class="fas fa-paper-plane"></i> Subscribe
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
    
    // Add animation to stats cards
    $('.stats-card').hover(function() {
        $(this).addClass('shadow-lg');
    }, function() {
        $(this).removeClass('shadow-lg');
    });
});
</script>
@endpush