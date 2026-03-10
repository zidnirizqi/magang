<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    // Ambil data 
    private function getCategories(Request $request)
    {
        if (!$request->session()->has('categories')) {
            $default = [];
            $request->session()->put('categories', $default);
        }

        return $request->session()->get('categories');
    }

    // Simpan data ke session
    private function saveCategories(Request $request, $categories)
    {
        $request->session()->put('categories', $categories);
    }

    // List category
    public function index(Request $request)
    {
        $categories = $this->getCategories($request);
        return view('admin.category.index', compact('categories'));
    }

    // Form tambah category
    public function create()
    {
        return view('admin.category.create');
    }

    // Simpan category baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categories = $this->getCategories($request);

        $newId = count($categories) ? max(array_column($categories, 'id')) + 1 : 1;

        $categories[] = [
            'id' => $newId,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => now()->toDateTimeString(),
        ];

        $this->saveCategories($request, $categories);

        return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
    }

    // Form edit category
    public function edit(Request $request, $id)
    {
        $categories = $this->getCategories($request);
        $category = collect($categories)->firstWhere('id', $id);

        return view('admin.category.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $categories = $this->getCategories($request);

        foreach ($categories as &$category) {
            if ($category['id'] == $id) {
                $category['name'] = $request->name;
                $category['description'] = $request->description;
            }
        }

        $this->saveCategories($request, $categories);

        return redirect()->route('admin.category.index')->with('success', 'Category updated successfully ');
    }

    // Hapus category
    public function destroy(Request $request, $id)
    {
        $categories = $this->getCategories($request);

        $categories = array_filter($categories, fn($c) => $c['id'] != $id);

        $this->saveCategories($request, $categories);

        return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
    }

    // ==================== API METHODS ====================

    // API: Get all categories
    public function apiIndex(): JsonResponse
    {
        try {
            $categories = Category::with('products')->get();
            
            $categoriesData = $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'status' => $category->status,
                    'products_count' => $category->products->count(),
                    'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $category->updated_at->format('Y-m-d H:i:s'),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categoriesData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Get single category
    public function apiShow($id): JsonResponse
    {
        try {
            $category = Category::with('products')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'status' => $category->status,
                    'products_count' => $category->products->count(),
                    'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $category->updated_at->format('Y-m-d H:i:s'),
                ]
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Create new category
    public function apiStore(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string',
                'status' => 'nullable|in:active,inactive'
            ]);

            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 'active'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'status' => $category->status,
                    'products_count' => 0,
                    'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $category->updated_at->format('Y-m-d H:i:s'),
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Update category
    public function apiUpdate(Request $request, $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'description' => 'nullable|string',
                'status' => 'nullable|in:active,inactive'
            ]);

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? $category->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'status' => $category->status,
                    'products_count' => $category->products->count(),
                    'created_at' => $category->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $category->updated_at->format('Y-m-d H:i:s'),
                ]
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Delete category
    public function apiDestroy($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            // Check if category has products
            if ($category->products()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete category. It has associated products.'
                ], 400);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // API: Toggle category status
    public function apiToggleStatus($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            
            $newStatus = $category->status === 'active' ? 'inactive' : 'active';
            $category->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'status' => $category->status,
                ]
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
