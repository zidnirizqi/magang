@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📂 Category Management</h2>

    <a href="{{ route('admin.category.create') }}" class="btn btn-primary mb-3">➕ Add New Category</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category['name'] }}</td>
                    <td>{{ $category['description'] }}</td>
                    <td>{{ $category['created_at'] }}</td>
                    <td>
                        <a href="{{ route('admin.category.edit', $category['id']) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                        <form action="{{ route('admin.category.destroy', $category['id']) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
