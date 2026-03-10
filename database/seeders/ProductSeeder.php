<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Get categories
        $electronics = Category::where('name', 'Electronics')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $smartphones = Category::where('name', 'Smartphones')->first();

        $products = [
            // Electronics
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'description' => 'High-performance gaming laptop with RTX 4060, Intel i7, 16GB RAM, 512GB SSD. Perfect for gaming and professional work.',
                'price' => 15999000,
                'stock' => 5,
                'status' => 'active',
                'category_id' => $electronics?->id ?? 1,
            ],
            [
                'name' => 'Wireless Headphones Sony WH-1000XM5',
                'description' => 'Premium noise-canceling wireless headphones with 30-hour battery life and superior sound quality.',
                'price' => 4999000,
                'stock' => 12,
                'status' => 'active',
                'category_id' => $electronics?->id ?? 1,
            ],
            [
                'name' => 'Smart Watch Apple Watch Series 9',
                'description' => 'Latest Apple Watch with health monitoring, GPS, and cellular connectivity. Available in multiple colors.',
                'price' => 6999000,
                'stock' => 8,
                'status' => 'active',
                'category_id' => $electronics?->id ?? 1,
            ],
            [
                'name' => 'Mechanical Keyboard Logitech MX Keys',
                'description' => 'Professional wireless mechanical keyboard with backlight and multi-device connectivity.',
                'price' => 1499000,
                'stock' => 15,
                'status' => 'active',
                'category_id' => $electronics?->id ?? 1,
            ],

            // Smartphones
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Available in 256GB.',
                'price' => 21999000,
                'stock' => 3,
                'status' => 'active',
                'category_id' => $smartphones?->id ?? 1,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen, 200MP camera, and AI features. 512GB storage.',
                'price' => 19999000,
                'stock' => 6,
                'status' => 'active',
                'category_id' => $smartphones?->id ?? 1,
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Google flagship phone with advanced AI photography and pure Android experience. 256GB.',
                'price' => 14999000,
                'stock' => 4,
                'status' => 'active',
                'category_id' => $smartphones?->id ?? 1,
            ],

            // Clothing
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'High-quality 100% cotton t-shirt available in multiple colors. Comfortable and durable.',
                'price' => 299000,
                'stock' => 25,
                'status' => 'active',
                'category_id' => $clothing?->id ?? 2,
            ],
            [
                'name' => 'Denim Jacket Classic',
                'description' => 'Timeless denim jacket made from premium denim fabric. Perfect for casual and semi-formal occasions.',
                'price' => 899000,
                'stock' => 10,
                'status' => 'active',
                'category_id' => $clothing?->id ?? 2,
            ],
            [
                'name' => 'Running Shoes Nike Air Max',
                'description' => 'Comfortable running shoes with air cushioning technology. Suitable for daily exercise and casual wear.',
                'price' => 1799000,
                'stock' => 18,
                'status' => 'active',
                'category_id' => $clothing?->id ?? 2,
            ],
            [
                'name' => 'Formal Shirt Business',
                'description' => 'Professional formal shirt made from wrinkle-free fabric. Available in white and light blue.',
                'price' => 599000,
                'stock' => 20,
                'status' => 'active',
                'category_id' => $clothing?->id ?? 2,
            ],

            // Books
            [
                'name' => 'The Psychology of Programming',
                'description' => 'Essential book for software developers about the human factors in programming and software development.',
                'price' => 450000,
                'stock' => 30,
                'status' => 'active',
                'category_id' => $books?->id ?? 4,
            ],
            [
                'name' => 'Clean Code: A Handbook',
                'description' => 'Learn how to write clean, maintainable code that is easy to read and understand.',
                'price' => 520000,
                'stock' => 25,
                'status' => 'active',
                'category_id' => $books?->id ?? 4,
            ],
            [
                'name' => 'Design Patterns: Elements',
                'description' => 'Classic book on software design patterns that every developer should read.',
                'price' => 680000,
                'stock' => 15,
                'status' => 'active',
                'category_id' => $books?->id ?? 4,
            ],
            [
                'name' => 'JavaScript: The Good Parts',
                'description' => 'Comprehensive guide to JavaScript programming language and best practices.',
                'price' => 420000,
                'stock' => 22,
                'status' => 'active',
                'category_id' => $books?->id ?? 4,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}