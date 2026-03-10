@extends('layouts.admin')

@section('title', 'Category Management')

@section('content')
<div class="container-fluid">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">📂 Category Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openCreateModal()">
            ➕ Add New Category
        </button>
    </div>

    <!-- Alert Messages -->
    <div id="alertMessage"></div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalCategories">0</h4>
                            <p class="mb-0">Total Categories</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-folder fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="activeCategories">0</h4>
                            <p class="mb-0">Active Categories</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="inactiveCategories">0</h4>
                            <p class="mb-0">Inactive Categories</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-pause-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="totalProducts">0</h4>
                            <p class="mb-0">Total Products</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="searchInput">Search Categories</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search by name or description...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="statusFilter">Filter by Status</label>
                        <select class="form-control" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-secondary d-block w-100" onclick="resetFilters()">Reset Filters</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Categories List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Products</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading categories...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="categoryName" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" rows="3"></textarea>
                        <div class="invalid-feedback" id="descriptionError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="categoryStatus" class="form-label">Status</label>
                        <select class="form-control" id="categoryStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span id="submitBtnText">Save Category</span>
                        <span id="submitBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this category?</p>
                <p><strong id="deleteCategoryName"></strong></p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <span id="deleteBtnText">Delete</span>
                    <span id="deleteBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let categories = [];
    let filteredCategories = [];
    let editingCategoryId = null;
    let deletingCategoryId = null;

    // Load categories on page load
    loadCategories();

    // Search functionality
    $('#searchInput').on('keyup', function() {
        filterCategories();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        filterCategories();
    });

    // Category form submission
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        saveCategory();
    });

    // Delete confirmation
    $('#confirmDeleteBtn').on('click', function() {
        deleteCategory(deletingCategoryId);
    });

    // Load categories from API
    function loadCategories() {
        $.ajax({
            url: '/api/categories',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    categories = response.data;
                    filteredCategories = categories;
                    renderCategories();
                    updateStatistics();
                }
            },
            error: function(xhr) {
                showAlert('danger', 'Failed to load categories: ' + (xhr.responseJSON?.message || 'Unknown error'));
            }
        });
    }

    // Filter categories based on search and status
    function filterCategories() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const statusFilter = $('#statusFilter').val();

        filteredCategories = categories.filter(category => {
            const matchesSearch = category.name.toLowerCase().includes(searchTerm) || 
                                (category.description && category.description.toLowerCase().includes(searchTerm));
            const matchesStatus = !statusFilter || category.status === statusFilter;
            
            return matchesSearch && matchesStatus;
        });

        renderCategories();
    }

    // Render categories table
    function renderCategories() {
        const tbody = $('#categoriesTableBody');
        
        if (filteredCategories.length === 0) {
            tbody.html(`
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No categories found</p>
                        </div>
                    </td>
                </tr>
            `);
            return;
        }

        let html = '';
        filteredCategories.forEach(category => {
            const statusBadge = category.status === 'active' 
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-secondary">Inactive</span>';

            html += `
                <tr>
                    <td>${category.id}</td>
                    <td><strong>${category.name}</strong></td>
                    <td>${category.description || '-'}</td>
                    <td>${statusBadge}</td>
                    <td><span class="badge bg-info">${category.products_count}</span></td>
                    <td>${formatDate(category.created_at)}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal(${category.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-${category.status === 'active' ? 'warning' : 'success'}" 
                                    onclick="toggleStatus(${category.id})" title="Toggle Status">
                                <i class="fas fa-${category.status === 'active' ? 'pause' : 'play'}"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(${category.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        tbody.html(html);
    }

    // Update statistics
    function updateStatistics() {
        const total = categories.length;
        const active = categories.filter(c => c.status === 'active').length;
        const inactive = total - active;
        const totalProducts = categories.reduce((sum, c) => sum + c.products_count, 0);

        $('#totalCategories').text(total);
        $('#activeCategories').text(active);
        $('#inactiveCategories').text(inactive);
        $('#totalProducts').text(totalProducts);
    }

    // Open create modal
    window.openCreateModal = function() {
        editingCategoryId = null;
        $('#categoryModalLabel').text('Add New Category');
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        clearFormErrors();
    }

    // Open edit modal
    window.openEditModal = function(id) {
        const category = categories.find(c => c.id === id);
        if (!category) return;

        editingCategoryId = id;
        $('#categoryModalLabel').text('Edit Category');
        $('#categoryId').val(category.id);
        $('#categoryName').val(category.name);
        $('#categoryDescription').val(category.description);
        $('#categoryStatus').val(category.status);
        clearFormErrors();
        
        $('#categoryModal').modal('show');
    }

    // Save category (create or update)
    function saveCategory() {
        const isEdit = editingCategoryId !== null;
        const url = isEdit ? `/api/categories/${editingCategoryId}` : '/api/categories';
        const method = isEdit ? 'PUT' : 'POST';

        const data = {
            name: $('#categoryName').val(),
            description: $('#categoryDescription').val(),
            status: $('#categoryStatus').val()
        };

        // Show loading
        $('#submitBtn').prop('disabled', true);
        $('#submitBtnText').addClass('d-none');
        $('#submitBtnSpinner').removeClass('d-none');

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#categoryModal').modal('hide');
                    showAlert('success', response.message);
                    loadCategories();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    displayFormErrors(xhr.responseJSON.errors);
                } else {
                    showAlert('danger', xhr.responseJSON?.message || 'Failed to save category');
                }
            },
            complete: function() {
                $('#submitBtn').prop('disabled', false);
                $('#submitBtnText').removeClass('d-none');
                $('#submitBtnSpinner').addClass('d-none');
            }
        });
    }

    // Open delete modal
    window.openDeleteModal = function(id) {
        const category = categories.find(c => c.id === id);
        if (!category) return;

        deletingCategoryId = id;
        $('#deleteCategoryName').text(category.name);
        $('#deleteModal').modal('show');
    }

    // Delete category
    function deleteCategory(id) {
        $('#confirmDeleteBtn').prop('disabled', true);
        $('#deleteBtnText').addClass('d-none');
        $('#deleteBtnSpinner').removeClass('d-none');

        $.ajax({
            url: `/api/categories/${id}`,
            type: 'DELETE',
            success: function(response) {
                if (response.success) {
                    $('#deleteModal').modal('hide');
                    showAlert('success', response.message);
                    loadCategories();
                }
            },
            error: function(xhr) {
                showAlert('danger', xhr.responseJSON?.message || 'Failed to delete category');
            },
            complete: function() {
                $('#confirmDeleteBtn').prop('disabled', false);
                $('#deleteBtnText').removeClass('d-none');
                $('#deleteBtnSpinner').addClass('d-none');
            }
        });
    }

    // Toggle category status
    window.toggleStatus = function(id) {
        $.ajax({
            url: `/api/categories/${id}/toggle-status`,
            type: 'PATCH',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    loadCategories();
                }
            },
            error: function(xhr) {
                showAlert('danger', xhr.responseJSON?.message || 'Failed to update status');
            }
        });
    }

    // Reset filters
    window.resetFilters = function() {
        $('#searchInput').val('');
        $('#statusFilter').val('');
        filteredCategories = categories;
        renderCategories();
    }

    // Show alert message
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('#alertMessage').html(alertHtml);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }

    // Display form validation errors
    function displayFormErrors(errors) {
        clearFormErrors();
        
        Object.keys(errors).forEach(field => {
            const input = $(`#category${field.charAt(0).toUpperCase() + field.slice(1)}`);
            const errorDiv = $(`#${field}Error`);
            
            input.addClass('is-invalid');
            errorDiv.text(errors[field][0]).show();
        });
    }

    // Clear form errors
    function clearFormErrors() {
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('').hide();
    }

    // Format date
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }
});
</script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection
