@extends('layouts.admin')

@section('title', 'Edit Brand')

@section('content')
    <form action="{{ route('admin.brand.update', $brand['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Brand Name</label>
            <input type="text" class="form-control" name="name" value="{{ $brand['name'] }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description">{{ $brand['description'] }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">💾 Update</button>
        <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">↩️ Back</a>
    </form>
@endsection
