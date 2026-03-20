<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class FrontService
{
    public function getFrontPageData()
    {
        // CEK APAKAH ADA DATA DI DATABASE
        $categories = Category::withCount('products')->get();
        $popularProducts = Product::with('category')->where('is_popular', true)->take(6)->get();

        // JIKA DATABASE KOSONG, KITA KASIH DATA DUMMY BIAR DESAIN KELIHATAN
        if ($categories->isEmpty()) {
            $categories = $this->getDummyCategories();
        }

        if ($popularProducts->isEmpty()) {
            $popularProducts = $this->getDummyProducts();
        }

        return [
            'categories' => $categories,
            'popularProducts' => $popularProducts,
        ];
    }

    // Fungsi pembantu buat bikin data Kategori palsu
    private function getDummyCategories()
    {
        return collect([
            (object)[ 'name' => 'Smartphones', 'slug' => 'smartphones', 'products' => collect([1,2,3]), 'products_count' => 12 ],
            (object)[ 'name' => 'Laptops', 'slug' => 'laptops', 'products' => collect([1,2]), 'products_count' => 8 ],
            (object)[ 'name' => 'Accessories', 'slug' => 'accessories', 'products' => collect([1,2,3,4]), 'products_count' => 25 ],
            (object)[ 'name' => 'Tablets', 'slug' => 'tablets', 'products' => collect([1]), 'products_count' => 5 ],
        ]);
    }

    // Fungsi pembantu buat bikin data Produk palsu
    private function getDummyProducts()
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'MacBook Pro M3 Max',
                'slug' => 'macbook-pro-m3-max',
                'price' => 45000000,
                'thumbnail' => 'https://picsum.photos/seed/mac/800/800',
                'description' => 'The most powerful laptop for professionals.',
                'stock' => 10,
                'category' => (object)['name' => 'Laptops']
            ],
            (object)[
                'id' => 2,
                'name' => 'iPhone 15 Pro Titanium',
                'slug' => 'iphone-15-pro',
                'price' => 21000000,
                'thumbnail' => 'https://picsum.photos/seed/iphone/800/800',
                'description' => 'Stronger and lighter with aerospace-grade titanium.',
                'stock' => 15,
                'category' => (object)['name' => 'Smartphones']
            ],
            (object)[
                'id' => 3,
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'price' => 5500000,
                'thumbnail' => 'https://picsum.photos/seed/sony/800/800',
                'description' => 'Industry-leading noise cancellation.',
                'stock' => 20,
                'category' => (object)['name' => 'Accessories']
            ],
        ]);
    }
}
