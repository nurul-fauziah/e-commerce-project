<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductPhoto;

class SmartTechSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset Data Lama dengan Aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Brand::truncate();
        Category::truncate();
        Product::truncate();
        ProductVariant::truncate();
        ProductPhoto::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Insert Brands (Lebih Banyak!)
        $brands = [
            ['name' => 'Apple', 'slug' => Str::slug('Apple'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=APPLE'],
            ['name' => 'ASUS ROG', 'slug' => Str::slug('ASUS ROG'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=ROG'],
            ['name' => 'Logitech', 'slug' => Str::slug('Logitech'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=LOGITECH'],
            ['name' => 'Razer', 'slug' => Str::slug('Razer'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=RAZER'],
            ['name' => 'Samsung', 'slug' => Str::slug('Samsung'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=SAMSUNG'],
            ['name' => 'Sony', 'slug' => Str::slug('Sony'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=SONY'],
            ['name' => 'Corsair', 'slug' => Str::slug('Corsair'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=CORSAIR'],
            ['name' => 'Dell', 'slug' => Str::slug('Dell'), 'logo' => 'https://placehold.co/200x200/000000/C5F277?text=DELL'],
        ];

        $brandMap = [];
        foreach ($brands as $b) {
            $brandMap[$b['name']] = Brand::create($b);
        }

        // 3. Insert Categories
        $categories = [
            ['name' => 'Laptops', 'slug' => Str::slug('Laptops'), 'icon' => 'https://placehold.co/100x100/000000/C5F277?text=LPT'],
            ['name' => 'Smartphones', 'slug' => Str::slug('Smartphones'), 'icon' => 'https://placehold.co/100x100/000000/C5F277?text=PHN'],
            ['name' => 'Gaming Gear', 'slug' => Str::slug('Gaming Gear'), 'icon' => 'https://placehold.co/100x100/000000/C5F277?text=GEAR'],
            ['name' => 'Accessories', 'slug' => Str::slug('Accessories'), 'icon' => 'https://placehold.co/100x100/000000/C5F277?text=ACC'],
        ];

        $catMap = [];
        foreach ($categories as $c) {
            $catMap[$c['name']] = Category::create($c);
        }

        // 4. THE MASSIVE PRODUCT INJECTION
        $products = [
            // --- KATEGORI: LAPTOPS ---
            [
                'st_brand_id' => $brandMap['ASUS ROG']->id,
                'st_category_id' => $catMap['Laptops']->id,
                'name' => 'ROG Zephyrus G14 (2025)',
                'slug' => Str::slug('ROG Zephyrus G14 2025'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=ROG+G14',
                'description' => 'Laptop gaming ultra-portable dengan performa buas. Dilengkapi AniMe Matrix LED di bagian punggung layar.',
                'specifications' => ['Processor' => 'AMD Ryzen 9 8945HS', 'GPU' => 'RTX 4070 8GB', 'Display' => '14" OLED 3K 120Hz', 'Weight' => '1.5 Kg'],
                'price' => 32999000, 'stock' => 15, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'ROG-G14-16', 'attributes' => ['RAM' => '16GB', 'Color' => 'Eclipse Gray'], 'price' => 32999000, 'stock' => 10],
                    ['sku' => 'ROG-G14-32', 'attributes' => ['RAM' => '32GB', 'Color' => 'Moonlight White'], 'price' => 35999000, 'stock' => 5],
                ]
            ],
            [
                'st_brand_id' => $brandMap['Apple']->id,
                'st_category_id' => $catMap['Laptops']->id,
                'name' => 'MacBook Pro 16-inch M3 Max',
                'slug' => Str::slug('MacBook Pro 16-inch M3 Max'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=MBP+16',
                'description' => 'Mesin paling ekstrem untuk developer. M3 Max memberikan tenaga gila untuk rendering 3D dan kompilasi kode.',
                'specifications' => ['Chipset' => 'M3 Max (16-core CPU)', 'Display' => 'Liquid Retina XDR', 'Battery' => 'Up to 22 hours'],
                'price' => 65999000, 'stock' => 8, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'MBP-16-48', 'attributes' => ['Memory' => '48GB Unified', 'Storage' => '1TB SSD'], 'price' => 65999000, 'stock' => 5],
                    ['sku' => 'MBP-16-128', 'attributes' => ['Memory' => '128GB Unified', 'Storage' => '4TB SSD'], 'price' => 85999000, 'stock' => 3],
                ]
            ],
            [
                'st_brand_id' => $brandMap['Razer']->id,
                'st_category_id' => $catMap['Laptops']->id,
                'name' => 'Razer Blade 16 (2025)',
                'slug' => Str::slug('Razer Blade 16 2025'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=BLADE+16',
                'description' => 'Sasis aluminium unibody CNC murni. Dibekali layar Dual-Mode Mini-LED (4K 120Hz / FHD 240Hz).',
                'specifications' => ['Processor' => 'Intel Core i9-14900HX', 'GPU' => 'RTX 4090 16GB', 'Chassis' => 'T6 CNC Aluminum'],
                'price' => 72000000, 'stock' => 5, 'is_popular' => false,
                'variants' => []
            ],
            [
                'st_brand_id' => $brandMap['Dell']->id,
                'st_category_id' => $catMap['Laptops']->id,
                'name' => 'Dell XPS 15 Creator Edition',
                'slug' => Str::slug('Dell XPS 15 Creator'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=XPS+15',
                'description' => 'Layar InfinityEdge nyaris tanpa bezel. Dirancang khusus untuk color grading dan desain grafis profesional.',
                'specifications' => ['Processor' => 'Intel Core i7-13700H', 'Display' => '15.6" 3.5K OLED Touch', 'Color_Gamut' => '100% DCI-P3'],
                'price' => 41500000, 'stock' => 12, 'is_popular' => false,
                'variants' => []
            ],

            // --- KATEGORI: SMARTPHONES ---
            [
                'st_brand_id' => $brandMap['Apple']->id,
                'st_category_id' => $catMap['Smartphones']->id,
                'name' => 'iPhone 15 Pro Max',
                'slug' => Str::slug('iPhone 15 Pro Max'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=IPHONE+15+PM',
                'description' => 'Ditempa dari titanium kelas kedirgantaraan. Chip A17 Pro mendobrak batas mobile gaming.',
                'specifications' => ['Chipset' => 'A17 Pro (3nm)', 'Camera' => '48MP + 5x Telephoto', 'Material' => 'Titanium'],
                'price' => 24999000, 'stock' => 30, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'IP15PM-256-NAT', 'attributes' => ['Storage' => '256GB', 'Color' => 'Natural'], 'price' => 24999000, 'stock' => 15],
                    ['sku' => 'IP15PM-512-BLK', 'attributes' => ['Storage' => '512GB', 'Color' => 'Black'], 'price' => 28999000, 'stock' => 15],
                ]
            ],
            [
                'st_brand_id' => $brandMap['Samsung']->id,
                'st_category_id' => $catMap['Smartphones']->id,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => Str::slug('Samsung Galaxy S24 Ultra'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=S24+ULTRA',
                'description' => 'Era baru Galaxy AI. Dilengkapi built-in S-Pen, layar anti-reflektif, dan kamera 200MP bertenaga AI.',
                'specifications' => ['Chipset' => 'Snapdragon 8 Gen 3 for Galaxy', 'Display' => '6.8" Dynamic AMOLED 2X', 'Features' => 'Galaxy AI, S-Pen'],
                'price' => 21999000, 'stock' => 40, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'S24U-256-GRY', 'attributes' => ['Storage' => '256GB', 'Color' => 'Titanium Gray'], 'price' => 21999000, 'stock' => 20],
                    ['sku' => 'S24U-512-VLT', 'attributes' => ['Storage' => '512GB', 'Color' => 'Titanium Violet'], 'price' => 23999000, 'stock' => 20],
                ]
            ],
            [
                'st_brand_id' => $brandMap['ASUS ROG']->id,
                'st_category_id' => $catMap['Smartphones']->id,
                'name' => 'ROG Phone 8 Pro',
                'slug' => Str::slug('ROG Phone 8 Pro'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=ROG+PHONE+8',
                'description' => 'Smartphone gaming sejati dengan AirTrigger ultrasonic, sistem pendingin aktif, dan baterai badak.',
                'specifications' => ['Chipset' => 'Snapdragon 8 Gen 3', 'Display' => '165Hz AMOLED', 'Cooling' => 'GameCool 8'],
                'price' => 19500000, 'stock' => 20, 'is_popular' => false,
                'variants' => []
            ],
            [
                'st_brand_id' => $brandMap['Samsung']->id,
                'st_category_id' => $catMap['Smartphones']->id,
                'name' => 'Samsung Galaxy Z Fold 5',
                'slug' => Str::slug('Galaxy Z Fold 5'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=Z+FOLD+5',
                'description' => 'Produktivitas level PC di saku Anda. Engsel Flex Hinge baru membuatnya tertutup rata tanpa celah.',
                'specifications' => ['Main_Display' => '7.6" Foldable Dynamic AMOLED', 'Cover_Display' => '6.2" AMOLED', 'Durability' => 'IPX8 Water Resistant'],
                'price' => 25999000, 'stock' => 15, 'is_popular' => false,
                'variants' => []
            ],

            // --- KATEGORI: GAMING GEAR ---
            [
                'st_brand_id' => $brandMap['Logitech']->id,
                'st_category_id' => $catMap['Gaming Gear']->id,
                'name' => 'Logitech G Pro X Superlight 2',
                'slug' => Str::slug('G Pro X Superlight 2'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=GPX+2',
                'description' => 'Mouse esports nirkabel tercepat. Berat hanya 60 gram dengan switch hybrid optical-mechanical.',
                'specifications' => ['Sensor' => 'HERO 2', 'Weight' => '60g', 'Polling_Rate' => '2000Hz'],
                'price' => 2399000, 'stock' => 50, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'GPX2-BLK', 'attributes' => ['Color' => 'Black'], 'price' => 2399000, 'stock' => 25],
                    ['sku' => 'GPX2-WHT', 'attributes' => ['Color' => 'White'], 'price' => 2399000, 'stock' => 25],
                ]
            ],
            [
                'st_brand_id' => $brandMap['Razer']->id,
                'st_category_id' => $catMap['Gaming Gear']->id,
                'name' => 'Razer Huntsman V3 Pro',
                'slug' => Str::slug('Razer Huntsman V3 Pro'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=HUNTSMAN+V3',
                'description' => 'Keyboard Analog Optical. Anda bisa mengatur titik aktuasi setiap tombol dari 0.1mm hingga 4.0mm.',
                'specifications' => ['Switches' => 'Analog Optical Gen-2', 'Actuation' => 'Adjustable 0.1-4.0mm', 'Format' => 'Full Size'],
                'price' => 4199000, 'stock' => 30, 'is_popular' => true,
                'variants' => []
            ],
            [
                'st_brand_id' => $brandMap['Sony']->id,
                'st_category_id' => $catMap['Gaming Gear']->id,
                'name' => 'Sony DualSense Edge',
                'slug' => Str::slug('Sony DualSense Edge'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=DUALSENSE+EDGE',
                'description' => 'Controller premium untuk PS5 & PC. Modul stik analog bisa dibongkar-pasang, dilengkapi back-paddles.',
                'specifications' => ['Customization' => 'Replaceable Stick Modules', 'Extra_Buttons' => '2 Back Paddles', 'Trigger' => 'Adjustable Stops'],
                'price' => 3599000, 'stock' => 25, 'is_popular' => false,
                'variants' => []
            ],
            [
                'st_brand_id' => $brandMap['Corsair']->id,
                'st_category_id' => $catMap['Gaming Gear']->id,
                'name' => 'Corsair Virtuoso RGB Wireless XT',
                'slug' => Str::slug('Corsair Virtuoso XT'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=VIRTUOSO+XT',
                'description' => 'Headset gaming audiophile. Mendukung koneksi Slipstream Wireless bersamaan dengan Bluetooth.',
                'specifications' => ['Drivers' => '50mm Neodymium', 'Mic' => 'Broadcast-grade Omni-directional', 'Audio' => 'Dolby Atmos'],
                'price' => 4500000, 'stock' => 15, 'is_popular' => false,
                'variants' => []
            ],

            // --- KATEGORI: ACCESSORIES ---
            [
                'st_brand_id' => $brandMap['Razer']->id,
                'st_category_id' => $catMap['Accessories']->id,
                'name' => 'Razer Core X - eGPU Enclosure',
                'slug' => Str::slug('Razer Core X eGPU'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=RAZER+CORE',
                'description' => 'Ubah laptop tipis menjadi mesin gaming desktop class. Mendukung kartu grafis PCIe terbaru via Thunderbolt.',
                'specifications' => ['Connection' => 'Thunderbolt 3', 'Power_Supply' => '650W ATX', 'Laptop_Charging' => '100W PD'],
                'price' => 5499000, 'stock' => 10, 'is_popular' => true,
                'variants' => []
            ],
            [
                'st_brand_id' => $brandMap['Samsung']->id,
                'st_category_id' => $catMap['Accessories']->id,
                'name' => 'Samsung T7 Shield Portable SSD 2TB',
                'slug' => Str::slug('Samsung T7 Shield 2TB'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=T7+SHIELD',
                'description' => 'SSD eksternal anti banting berbalut elastomer. Kecepatan transfer hingga 1,050 MB/s.',
                'specifications' => ['Capacity' => '2TB', 'Speed' => '1050 MB/s Read', 'Durability' => 'IP65 Water/Dust Resistant'],
                'price' => 2899000, 'stock' => 60, 'is_popular' => true,
                'variants' => [
                    ['sku' => 'T7S-2TB-BLK', 'attributes' => ['Color' => 'Black'], 'price' => 2899000, 'stock' => 30],
                    ['sku' => 'T7S-2TB-BLU', 'attributes' => ['Color' => 'Blue'], 'price' => 2899000, 'stock' => 30],
                ]
            ],
            [
                'st_brand_id' => $brandMap['Apple']->id,
                'st_category_id' => $catMap['Accessories']->id,
                'name' => 'Apple Magic Trackpad',
                'slug' => Str::slug('Apple Magic Trackpad'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=TRACKPAD',
                'description' => 'Permukaan kaca edge-to-edge. Mendukung seluruh gestur Multi-Touch macOS dan teknologi Force Touch.',
                'specifications' => ['Connectivity' => 'Bluetooth, Lightning', 'Feature' => 'Force Touch Sensors'],
                'price' => 2499000, 'stock' => 45, 'is_popular' => false,
                'variants' => [
                    ['sku' => 'AMT-WHT', 'attributes' => ['Color' => 'White'], 'price' => 2499000, 'stock' => 25],
                    ['sku' => 'AMT-BLK', 'attributes' => ['Color' => 'Black'], 'price' => 2799000, 'stock' => 20], // Warna hitam selalu lebih mahal di Apple wkwk
                ]
            ],
            [
                'st_brand_id' => $brandMap['Logitech']->id,
                'st_category_id' => $catMap['Accessories']->id,
                'name' => 'Logitech MX Master 3S',
                'slug' => Str::slug('Logitech MX Master 3S'),
                'thumbnail' => 'https://placehold.co/800x800/000000/C5F277?text=MX+MASTER+3S',
                'description' => 'Mouse produktivitas absolut. Scroll wheel MagSpeed elektromagnetik, klik super senyap, sensor bisa di kaca.',
                'specifications' => ['Sensor' => '8000 DPI Darkfield', 'Buttons' => '7 Custom Buttons', 'Scroll' => 'MagSpeed Electromagnetic'],
                'price' => 1799000, 'stock' => 35, 'is_popular' => true,
                'variants' => []
            ]
        ];

        // 5. Eksekusi Insert Produk + Varian + Foto Galeri
        foreach ($products as $pData) {
            $variants = $pData['variants'] ?? [];
            unset($pData['variants']);

            // Insert Product Utama
            $product = Product::create($pData);

            // Insert Variants (Jika Ada)
            if (!empty($variants)) {
                foreach ($variants as $var) {
                    $var['st_product_id'] = $product->id;
                    ProductVariant::create($var);
                }
            }

            // Bikin 3 foto dummy untuk setiap produk (Biar galeri gak kosong)
            for ($i = 1; $i <= 3; $i++) {
                ProductPhoto::create([
                    'st_product_id' => $product->id,
                    'photo' => 'https://placehold.co/600x600/000000/C5F277?text=ANGLE+0' . $i
                ]);
            }
        }

        $this->command->info('System Overloaded! 16 Premium Devices injected into the database.');
    }
}
