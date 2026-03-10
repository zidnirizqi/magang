<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // Ambil data brand dari session
    private function getBrands(Request $request)
    {
        if (!$request->session()->has('brands')) {
            
            $default = [
            ];
            $request->session()->put('brands', $default);
        }

        return $request->session()->get('brands');
    }

    // Simpan brand ke session
    private function saveBrands(Request $request, $brands)
    {
        $request->session()->put('brands', $brands);
    }

    // List brand
    public function index(Request $request)
    {
        $brands = $this->getBrands($request);
        return view('admin.brand.index', compact('brands'));
    }

    // Form tambah brand
    public function create()
    {
        return view('admin.brand.create');
    }

    // Simpan brand baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $brands = $this->getBrands($request);
        $newId = count($brands) ? max(array_column($brands, 'id')) + 1 : 1;

        $brands[] = [
            'id' => $newId,
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => now()->toDateTimeString(),
        ];

        $this->saveBrands($request, $brands);

        return redirect()->route('admin.brand.index')->with('success', 'Brand created successfully');
    }

    // Form edit brand
    public function edit(Request $request, $id)
    {
        $brands = $this->getBrands($request);
        $brand = collect($brands)->firstWhere('id', $id);

        return view('admin.brand.edit', compact('brand'));
    }

    // Update brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $brands = $this->getBrands($request);

        foreach ($brands as &$brand) {
            if ($brand['id'] == $id) {
                $brand['name'] = $request->name;
                $brand['description'] = $request->description;
            }
        }

        $this->saveBrands($request, $brands);

        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully');
    }

    // Hapus brand
    public function destroy(Request $request, $id)
    {
        $brands = $this->getBrands($request);

        $brands = array_filter($brands, fn($b) => $b['id'] != $id);

        $this->saveBrands($request, $brands);

        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully');
    }
}
