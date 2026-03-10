@extends('layouts.admin')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Product</h5>
          <a href="{{ route('admin.shop.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
          </a>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.shop.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

              {{-- Product Name --}}
              <div class="col-md-6">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" 
                       value="{{ old('name', $product->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Category --}}
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select class="form-select @error('category_id') is-invalid @enderror" 
                        id="category_id" name="category_id" required>
                  <option value="">-- Select Category --</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                      {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Price --}}
              <div class="col-md-6">
                <label for="price" class="form-label">Price</label>
                <input type="number" 
                       class="form-control @error('price') is-invalid @enderror" 
                       id="price" name="price" 
                       value="{{ old('price', $product->price) }}" required>
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Stock --}}
              <div class="col-md-6">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" 
                       class="form-control @error('stock') is-invalid @enderror" 
                       id="stock" name="stock" 
                       value="{{ old('stock', $product->stock) }}" required>
                @error('stock')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Description --}}
              <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Image Upload --}}
              <div class="col-md-6">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" 
                       class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" onchange="previewImage(this)">
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Preview Image --}}
              <div class="col-md-6 d-flex align-items-center">
                <img id="imagePreview" 
                     src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/200' }}" 
                     class="img-thumbnail image-preview" 
                     alt="Preview">
              </div>

              {{-- Status --}}
              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                  <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

            </div> {{-- row --}}

            <div class="mt-4 d-flex justify-content-end">
              <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save me-1"></i> Update Product
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => preview.src = e.target.result;
      reader.readAsDataURL(file);
    }
  }
</script>
@endpush
