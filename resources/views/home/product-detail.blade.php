@extends('layouts.app')

@section('title', $product->name . ' - ShopApp')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category', $product->category->id) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="row">
        <div class="col-lg-6">
            <!-- Product Image -->
            <div class="card">
                <div class="product-image-large">
                    @switch($product->category->name ?? 'default')
                        @case('Electronics')
                            <i class="fas fa-laptop fa-8x text-primary"></i>
                            @break
                        @case('Smartphones')
                            <i class="fas fa-mobile-alt fa-8x text-warning"></i>
                            @break
                        @case('Clothing')
                            <i class="fas fa-tshirt fa-8x text-success"></i>
                            @break
                        @case('Books')
                            <i class="fas fa-book fa-8x text-info"></i>
                            @break
                        @case('Sports')
                            <i class="fas fa-football-ball fa-8x text-danger"></i>
                            @break
                        @default
                            <i class="fas fa-box fa-8x text-secondary"></i>
                    @endswitch
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="badge bg-secondary fs-6">{{ $product->category->name }}</span>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} fs-6 ms-2">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                
                <!-- Product Name -->
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                
                <!-- Price -->
                <div class="mb-4">
                    <span class="display-5 fw-bold text-success">{{ $product->formatted_price }}</span>
                </div>
                
                <!-- Stock Info -->
                <div class="mb-4">
                    <div class="row">
                        <div class="col-6">
                            <strong>Stock Available:</strong>
                            <span class="text-primary">{{ $product->stock }} units</span>
                        </div>
                        <div class="col-6">
                            <strong>Status:</strong>
                            <span class="text-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <h5 class="fw-bold">Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="d-grid gap-2 d-md-flex">
                    @if($product->stock > 0)
                        <button class="btn btn-success btn-lg me-md-2" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                        <button class="btn btn-primary btn-lg" onclick="buyNow({{ $product->id }})">
                            <i class="fas fa-bolt"></i> Buy Now
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>
                            <i class="fas fa-times"></i> Out of Stock
                        </button>
                    @endif
                </div>
                
                <!-- Additional Info -->
                <div class="mt-4 p-3 bg-light rounded">
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="fas fa-truck fa-2x text-primary mb-2"></i>
                            <p class="small mb-0"><strong>Free Shipping</strong><br>On orders over Rp 500,000</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-undo fa-2x text-success mb-2"></i>
                            <p class="small mb-0"><strong>Easy Returns</strong><br>30-day return policy</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-shield-alt fa-2x text-info mb-2"></i>
                            <p class="small mb-0"><strong>Warranty</strong><br>1-year manufacturer warranty</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="fw-bold mb-4">Related Products</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-6">
                <div class="card product-card h-100">
                    <div class="position-relative">
                        <div class="product-image">
                            @switch($related->category->name ?? 'default')
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
                        <span class="badge-stock {{ $related->stock > 0 ? '' : 'out-of-stock' }}">
                            {{ $related->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold">{{ $related->name }}</h6>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($related->description, 60) }}
                        </p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="price-tag">{{ $related->formatted_price }}</span>
                                <small class="text-muted">Stock: {{ $related->stock }}</small>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('product.detail', $related->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p id="successMessage">Product added to cart successfully!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                <button type="button" class="btn btn-primary">View Cart</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.product-image-large {
    height: 400px;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border-radius: 15px;
}

.product-info {
    padding: 20px;
}

@media (max-width: 768px) {
    .product-image-large {
        height: 250px;
    }
    
    .product-image-large i {
        font-size: 4rem !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
function addToCart(productId) {
    // Simulate add to cart functionality
    $('#successMessage').text('Product added to cart successfully!');
    $('#successModal').modal('show');
    
    // Here you would typically make an AJAX call to add the product to cart
    console.log('Adding product to cart:', productId);
}

function buyNow(productId) {
    // Simulate buy now functionality
    $('#successMessage').text('Redirecting to checkout...');
    $('#successModal').modal('show');
    
    // Here you would typically redirect to checkout page
    setTimeout(() => {
        console.log('Redirecting to checkout for product:', productId);
        // window.location.href = '/checkout';
    }, 2000);
}

$(document).ready(function() {
    // Add smooth scrolling for related products
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});
</script>
@endpush