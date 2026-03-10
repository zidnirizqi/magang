@extends('layouts.admin')

@section('content')
<h2>Edit User</h2>

<form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="w-50">
    @csrf @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (opsional)</label>
        <input type="password" name="password" class="form-control">
        <small class="text-muted">Leave blank if you don't want to change the password</small>
    </div>
    <button type="submit" class="btn btn-success">💾 Update</button>
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">↩️ Back</a>
</form>
@endsection
