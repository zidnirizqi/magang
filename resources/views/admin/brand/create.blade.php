@extends('layouts.admin')

@section('title', 'Add Brand')

@section('content')
    <form action="{{ route('admin.brand.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Brand Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-success">💾 Save</button>
        <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">↩️ Back</a>
    </form>
@endsection
