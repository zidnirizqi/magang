@extends('layouts.admin')

@section('title', 'Brand')

@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.brand.create') }}" class="btn btn-primary btn-sm">➕ Add New Brand</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand['id'] }}</td>
                    <td>{{ $brand['name'] }}</td>
                    <td>{{ $brand['description'] }}</td>
                    <td>
                        <a href="{{ route('admin.brand.edit', $brand['id']) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                        <form action="{{ route('admin.brand.destroy', $brand['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?')">🗑 Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
