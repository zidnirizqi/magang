@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">📄 Pages List</h5>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">➕ Add New Pages</a>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Slug</th>
          <th>Status</th>
          <th width="180">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>About Us</td>
          <td>about-us</td>
          <td><span class="badge bg-success">Published</span></td>
          <td>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-warning btn-sm">✏️ Edit</a>
            <!-- Delete Button trigger modal -->
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal1">🗑️ Delete</button>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>Contact</td>
          <td>contact</td>
          <td><span class="badge bg-secondary">Draft</span></td>
          <td>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-warning btn-sm">✏️ Edit</a>
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal2">🗑️ Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Delete Modal 1 -->
<div class="modal fade" id="deleteModal1" tabindex="-1" aria-labelledby="deleteModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">⚠️ Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong>About Us</strong> page?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="#" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">🗑️ Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal 2 -->
<div class="modal fade" id="deleteModal2" tabindex="-1" aria-labelledby="deleteModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">⚠️ Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete <strong>Contact</strong> page?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="#" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">🗑️ Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
