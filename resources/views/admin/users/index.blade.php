@extends('layouts.admin')

@section('title', 'List Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- <h2>List Users</h2> --}}
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary">➕ Add New Users</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">✏️ Edit</a>
                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">🗑 Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
