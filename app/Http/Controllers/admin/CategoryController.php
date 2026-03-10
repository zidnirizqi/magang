<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
