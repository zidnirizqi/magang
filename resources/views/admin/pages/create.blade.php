@extends('layouts.admin')

@section('title', 'Create Pages')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">
    <h5 class="mb-0">➕ Create New Pages</h5>
  </div>
  <div class="card-body">
    <form action="#" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Pages Title</label>
        <input type="text" class="form-control" name="title" placeholder="Enter page title">
      </div>
      <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" class="form-control" name="slug" placeholder="auto-generated if empty">
      </div>
      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea class="form-control" name="content" rows="5"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
          <option value="published">Published</option>
          <option value="draft">Draft</option>
        </select>
      </div>
      <button type="submit" class="btn btn-success">💾 Save</button>
      <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">↩️ Back</a>
    </form>
  </div>
</div>
@endsection