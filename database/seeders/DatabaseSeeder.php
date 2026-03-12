<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT USER ADMIN & CUSTOMER
        User::create([
            'name' => 'Admin SmartTech',
            'email' => 'admin@smarttech.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Nurul Fauziah',
            'email' => 'nurul@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. DATA KATEGORI (Hardware Classification)
        $categories = [
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'icon' => 'smartphone.png'],
            ['name' => 'Laptops', 'slug' => 'laptops', 'icon' => 'laptop.png'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'icon' => 'headphones.png'],
            ['name' => 'Gaming Gear', 'slug' => 'gaming-gear', 'icon' => 'controller.png'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 3. DATA BRAND
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple', 'logo' => 'apple.png'],
            ['name' => 'Samsung', 'slug' => 'samsung', 'logo' => 'samsung.png'],
            ['name' => 'Asus ROG', 'slug' => 'asus-rog', 'logo' => 'rog.png'],
            ['name' => 'Sony', 'slug' => 'sony', 'logo' => 'sony.png'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // 4. DATA PRODUK (Hardware Units)
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'thumbnail' => 'https://picsum.photos/seed/iphone/800/800',
                'description' => 'Titanium design with A17 Pro chip. The ultimate smartphone performance.',
                'price' => 24999000,
                'stock' => 15,
                'is_popular' => true,
                'st_category_id' => 1, // Smartphones
                'st_brand_id' => 1,    // Apple
            ],
            [
                'name' => 'MacBook Pro M3 Max',
                'slug' => 'macbook-pro-m3-max',
                'thumbnail' => 'https://picsum.photos/seed/macbook/800/800',
                'description' => 'The most advanced chips ever built for a personal computer.',
                'price' => 45000000,
                'stock' => 5,
                'is_popular' => true,
                'st_category_id' => 2, // Laptops
                'st_brand_id' => 1,    // Apple
            ],
            [
                'name' => 'ROG Zephyrus G14',
                'slug' => 'rog-zephyrus-g14',
                'thumbnail' => 'https://picsum.photos/seed/rog/800/800',
                'description' => 'Powerful, portable, and versatile gaming laptop with AniMe Matrix.',
                'price' => 28000000,
                'stock' => 8,
                'is_popular' => true,
                'st_category_id' => 2, // Laptops
                'st_brand_id' => 3,    // Asus
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'thumbnail' => 'https://picsum.photos/seed/sony/800/800',
                'description' => 'Industry-leading noise canceling with magnificent sound.',
                'price' => 5499000,
                'stock' => 20,
                'is_popular' => true,
                'st_category_id' => 3, // Accessories
                'st_brand_id' => 4,    // Sony
            ],
        ];

        foreach ($products as $p) {
            $newProduct = Product::create($p);

            // 5. DATA VARIAN (Technical Specs)
            // Kita buatin varian otomatis buat tiap produk
            $newProduct->variants()->createMany([
                ['name' => 'Storage', 'value' => '256GB'],
                ['name' => 'Storage', 'value' => '512GB'],
                ['name' => 'Color', 'value' => 'Industrial Grey'],
                ['name' => 'Color', 'value' => 'Midnight Black'],
            ]);
        }

        // 6. DATA PROMO CODE
        PromoCode::create([
            'code' => 'SMARTTECH2026',
            'discount_amount' => 500000,
        ]);

        PromoCode::create([
            'code' => 'NEWUSER',
            'discount_amount' => 100000,
        ]);
    }
}
