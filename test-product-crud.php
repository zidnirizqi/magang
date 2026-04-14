<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\Category;

echo "Testing Product CRUD System...\n";

// Get first category
$category = Category::first();
if (!$category) {
    echo "No categories found. Please create a category first.\n";
    exit(1);
}

echo "Available category: {$category->name} (ID: {$category->id})\n";

// Create a test product
$product = Product::create([
    'name' => 'Test Product via CRUD',
    'description' => 'This product was created to test the CRUD system',
    'price' => 75000,
    'stock' => 15,
    'category_id' => $category->id,
    'status' => 'active'
]);

echo "Product created successfully!\n";
echo "Product ID: {$product->id}\n";
echo "Product Name: {$product->name}\n";
echo "Category: {$product->category->name}\n";
echo "Price: Rp " . number_format($product->price, 0, ',', '.') . "\n";
echo "Stock: {$product->stock} units\n";
echo "Status: {$product->status}\n";

// Test if it appears on landing page
$landingProducts = Product::with('category')->active()->inStock()->get();
echo "\nTotal active products on landing page: " . $landingProducts->count() . "\n";

// Find our test product
$testProduct = $landingProducts->where('id', $product->id)->first();
if ($testProduct) {
    echo "✅ Test product appears on landing page!\n";
} else {
    echo "❌ Test product NOT found on landing page!\n";
}

echo "\nCRUD Test completed!\n";