<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <h5 class="mb-0">📦 Products List</h5>
      <a href="{{ route('admin.shop.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Add Product
      </a>
    </div>
    <div class="card-body table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}" class="product-img">
                @else
                  <span class="text-muted">No image</span>
                @endif
              </td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->category?->name }}</td>
              <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
              <td>{{ $product->stock }}</td>
              <td>
                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }} status-badge">
                  {{ ucfirst($product->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.shop.edit', $product->id) }}" class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.shop.destroy', $product->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">No products available</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $products->links() }}
    </div>
  </div>