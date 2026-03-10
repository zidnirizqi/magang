<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (active and in stock)
        $featuredProducts = Product::with('category')
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // Get all active categories with product count
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active()->where('stock', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->get();

        // Get statistics
        $stats = [
            'total_products' => Product::active()->inStock()->count(),
            'total_categories' => Category::active()->count(),
            'featured_count' => $featuredProducts->count(),
        ];

        return view('home.index', compact('featuredProducts', 'categories', 'stats'));
    }

    public function products(Request $request)
    {
        $query = Product::with('category')->active()->inStock();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search by name or description
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Sort by price
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        
        // Get all active categories for filter
        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->active()->where('stock', '>', 0);
            }])
            ->having('products_count', '>', 0)
            ->get();

        return view('home.products', compact('products', 'categories'));
    }

    public function productDetail($id)
    {
        $product = Product::with('category')
            ->active()
            ->findOrFail($id);

        // Get related products from same category
        $relatedProducts = Product::with('category')
            ->active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('home.product-detail', compact('product', 'relatedProducts'));
    }

    public function category($id)
    {
        $category = Category::active()->findOrFail($id);
        
        $products = Product::with('category')
            ->active()
            ->inStock()
            ->where('category_id', $id)
            ->latest()
            ->paginate(12);

        return view('home.category', compact('category', 'products'));
    }
}