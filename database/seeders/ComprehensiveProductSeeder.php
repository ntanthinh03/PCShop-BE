<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComprehensiveProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure categories exist
        $categoriesData = [
            ['name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Laptop học tập, làm việc văn phòng'],
            ['name' => 'Laptop Gaming', 'slug' => 'laptop-gaming', 'description' => 'Laptop gaming cấu hình cao, màn hình tần số quét lớn'],
            ['name' => 'PC Gaming', 'slug' => 'pc-gaming', 'description' => 'Máy tính PC Gaming, PC Đồ họa, PC AI lắp sẵn hiệu năng cao'],
            ['name' => 'Main, CPU, VGA', 'slug' => 'main-cpu-vga', 'description' => 'Linh kiện cốt lõi: Bo mạch chủ, Vi xử lý, Card màn hình'],
            ['name' => 'Case, Nguồn, Tản', 'slug' => 'case-nguon-tan', 'description' => 'Vỏ máy tính, Nguồn công suất thực và Tản nhiệt nước/khí'],
            ['name' => 'Ổ cứng, RAM', 'slug' => 'o-cung-ram', 'description' => 'RAM DDR4/DDR5, Ổ cứng SSD NVMe và Thẻ nhớ USB'],
            ['name' => 'Loa, Micro, Webcam', 'slug' => 'audio', 'description' => 'Thiết bị âm thanh, Loa, Microphone stream và Webcam HD'],
            ['name' => 'Màn hình', 'slug' => 'man-hinh', 'description' => 'Màn hình máy tính Gaming 144Hz - 360Hz, IPS 2K/4K, OLED'],
            ['name' => 'Bàn phím', 'slug' => 'ban-phim', 'description' => 'Bàn phím cơ Wireless, Custom Hot-swap'],
            ['name' => 'Chuột + Lót', 'slug' => 'chuot-lot', 'description' => 'Chuột gaming không dây siêu nhẹ, lót chuột bo viền'],
            ['name' => 'Tai Nghe', 'slug' => 'tai-nghe', 'description' => 'Tai nghe Gaming 7.1 surround sound'],
            ['name' => 'Ghế - Bàn', 'slug' => 'ghe-ban', 'description' => 'Ghế công thái học Ergonomic và bàn gaming'],
            ['name' => 'Phần mềm', 'slug' => 'phan-mem', 'description' => 'Hệ điều hành Windows và phần mềm bản quyền Office'],
            ['name' => 'Phụ kiện', 'slug' => 'phu-kien', 'description' => 'Dây cáp, Hub USB, giá đỡ tai nghe, tay cầm chơi game'],
            ['name' => 'Thu cũ đổi mới', 'slug' => 'thu-cu-doi-moi', 'description' => 'Dịch vụ thu cũ đổi mới linh kiện PC nâng cấp giá tốt'],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::firstOrCreate(
                ['slug' => $cData['slug']],
                $cData
            );
        }

        // Default placeholder image fallback map
        $imgMap = [
            'monitor' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600',
            'pc' => 'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=600',
            'case' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=600',
            'psu' => 'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=600',
            'cooling' => 'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=600',
            'ssd' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=600',
            'ram' => 'https://images.unsplash.com/photo-1562976540-1502c2145186?w=600',
            'audio' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?w=600',
            'keyboard' => 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?w=600',
            'mouse' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600',
            'headset' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600',
            'chair' => 'https://images.unsplash.com/photo-1580481072645-022f9a6d8310?w=600',
        ];

        // -------------------------------------------------------------
        // 2. MÀN HÌNH (MONITORS) - 60+ REAL PRODUCTS FROM GOOGLE
        // -------------------------------------------------------------
        $monitorsData = [
            // Dell
            ['brand' => 'Dell', 'name' => 'Màn hình Dell UltraSharp U2723QE 27 inch 4K IPS Type-C', 'price' => 12890000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '60Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Dell', 'name' => 'Màn hình Dell S2722QC 27 inch 4K IPS Loa tích hợp', 'price' => 8490000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '60Hz', 'ms' => '4ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Dell', 'name' => 'Màn hình Dell SE2422H 23.8 inch FHD VA 75Hz', 'price' => 2490000, 'panel' => 'VA', 'res' => 'FHD', 'hz' => '75Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Dell', 'name' => 'Màn hình Gaming Dell Alienware AW2723DF 27 inch 2K 280Hz IPS', 'price' => 16990000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '280Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'Dell', 'name' => 'Màn hình Gaming Dell G2724D 27 inch QHD 2K Fast IPS 165Hz', 'price' => 6790000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],

            // LG
            ['brand' => 'LG', 'name' => 'Màn hình Gaming LG UltraGear 27GP850-B 27 inch Nano IPS 2K 180Hz', 'price' => 8290000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '180Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'LG', 'name' => 'Màn hình Gaming LG UltraGear 24GN600-B 23.8 inch IPS FHD 144Hz', 'price' => 3190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '144Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'LG', 'name' => 'Màn hình Gaming LG UltraGear 27GR95QE-B 27 inch QHD OLED 240Hz', 'price' => 21990000, 'panel' => 'OLED', 'res' => '2K', 'hz' => '240Hz', 'ms' => '0.03ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'LG', 'name' => 'Màn hình Đồ họa LG 27UP650-W 27 inch 4K IPS HDR400', 'price' => 6990000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '60Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'LG', 'name' => 'Màn hình Cong LG UltraWide 34WP65G-B 34 inch WFHD IPS 75Hz', 'price' => 7490000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '75Hz', 'ms' => '5ms', 'surface' => 'Cong', 'sync' => 'FreeSync'],

            // Samsung
            ['brand' => 'SAMSUNG', 'name' => 'Màn hình Cong Gaming Samsung Odyssey G5 LC27G55 27 inch 2K 144Hz', 'price' => 5290000, 'panel' => 'VA', 'res' => '2K', 'hz' => '144Hz', 'ms' => '1ms', 'surface' => 'Cong', 'sync' => 'FreeSync'],
            ['brand' => 'SAMSUNG', 'name' => 'Màn hình Cong Gaming Samsung Odyssey OLED G9 G95SC 49 inch 240Hz 0.03ms', 'price' => 34990000, 'panel' => 'OLED', 'res' => '4K', 'hz' => '240Hz', 'ms' => '0.03ms', 'surface' => 'Cong', 'sync' => 'G-Sync'],
            ['brand' => 'SAMSUNG', 'name' => 'Màn hình Samsung ViewFinity S8 S80PB 27 inch 4K IPS HDR400 Type-C', 'price' => 8990000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '60Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'SAMSUNG', 'name' => 'Màn hình Gaming Samsung Odyssey G3 G32A 24 inch FHD 165Hz', 'price' => 3390000, 'panel' => 'VA', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'SAMSUNG', 'name' => 'Màn hình Samsung LS24R350 23.8 inch FHD IPS 75Hz viền mỏng', 'price' => 2290000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '75Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // ASUS
            ['brand' => 'ASUS', 'name' => 'Màn hình Gaming ASUS TUF Gaming VG249Q3A 23.8 inch IPS FHD 180Hz 1ms', 'price' => 3290000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '180Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'ASUS', 'name' => 'Màn hình Gaming ASUS ROG Swift OLED PG27AQDM 27 inch 2K 240Hz 0.03ms', 'price' => 23990000, 'panel' => 'OLED', 'res' => '2K', 'hz' => '240Hz', 'ms' => '0.03ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'ASUS', 'name' => 'Màn hình Đồ họa ASUS ProArt PA278QV 27 inch 2K IPS 100% sRGB', 'price' => 7190000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '75Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'ASUS', 'name' => 'Màn hình Gaming ASUS TUF VG27AQ3A 27 inch QHD 2K Fast IPS 180Hz', 'price' => 6490000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '180Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'ASUS', 'name' => 'Màn hình ASUS VY249HE 23.8 inch FHD IPS 75Hz Kháng khuẩn Eye Care', 'price' => 2190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '75Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // Acer
            ['brand' => 'Acer', 'name' => 'Màn hình Gaming Acer Nitro VG270 E 27 inch FHD IPS 100Hz 1ms', 'price' => 2990000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '100Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Acer', 'name' => 'Màn hình Gaming Acer Predator XB283K KV 28 inch 4K IPS 144Hz Type-C', 'price' => 14990000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '144Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'Acer', 'name' => 'Màn hình Gaming Acer Nitro XV240Y M3 23.8 inch IPS FHD 180Hz', 'price' => 3090000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '180Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // AOC
            ['brand' => 'AOC', 'name' => 'Màn hình Gaming AOC 24G2SP 23.8 inch IPS FHD 165Hz 1ms Ergonomic', 'price' => 3190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'AOC', 'name' => 'Màn hình Gaming AOC 27G2SP 27 inch IPS FHD 165Hz G-Sync Compatible', 'price' => 4190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],
            ['brand' => 'AOC', 'name' => 'Màn hình Cong Gaming AOC CQ27G3Z 27 inch 2K QHD VA 240Hz 0.5ms', 'price' => 6990000, 'panel' => 'VA', 'res' => '2K', 'hz' => '240Hz', 'ms' => '0.5ms', 'surface' => 'Cong', 'sync' => 'FreeSync'],

            // ViewSonic
            ['brand' => 'Viewsonic', 'name' => 'Màn hình Gaming ViewSonic VX2428 23.8 inch IPS FHD 180Hz 0.5ms HDR10', 'price' => 2890000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '180Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Viewsonic', 'name' => 'Màn hình Gaming ViewSonic XG2431 23.8 inch IPS FHD 240Hz Fast IPS Blur Busters', 'price' => 7490000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '240Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Viewsonic', 'name' => 'Màn hình ViewSonic ColorEdge VP2756-4K 27 inch 4K IPS Pantone Validated', 'price' => 11990000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '60Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // BenQ
            ['brand' => 'BenQ', 'name' => 'Màn hình Esport BenQ Zowie XL2546K 24.5 inch TN FHD 240Hz DyAc+', 'price' => 12490000, 'panel' => 'TN', 'res' => 'FHD', 'hz' => '240Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'BenQ', 'name' => 'Màn hình Gaming BenQ MOBIUZ EX2710S 27 inch IPS FHD 165Hz TreVolo Sound', 'price' => 5690000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // Gigabyte
            ['brand' => 'GIGABYTE', 'name' => 'Màn hình Gaming GIGABYTE G24F 2 23.8 inch IPS FHD 165Hz (OC 180Hz)', 'price' => 3190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '180Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'GIGABYTE', 'name' => 'Màn hình Gaming GIGABYTE M27Q 27 inch SS IPS 2K 170Hz KVM Switch', 'price' => 6990000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '170Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],

            // Xiaomi
            ['brand' => 'Xiaomi', 'name' => 'Màn hình Xiaomi Gaming G27i 27 inch IPS FHD 165Hz 1ms', 'price' => 2990000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Xiaomi', 'name' => 'Màn hình Cong Xiaomi Curved Gaming Monitor 34 inch WQHD 144Hz 1500R', 'price' => 6990000, 'panel' => 'VA', 'res' => '2K', 'hz' => '144Hz', 'ms' => '4ms', 'surface' => 'Cong', 'sync' => 'FreeSync'],

            // MSI
            ['brand' => 'MSI', 'name' => 'Màn hình Gaming MSI G2712 27 inch IPS FHD 170Hz 1ms FreeSync Premium', 'price' => 3890000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '170Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'MSI', 'name' => 'Màn hình Gaming MSI MAG 274UPF 27 inch 4K Rapid IPS 144Hz Type-C 65W', 'price' => 12990000, 'panel' => 'IPS', 'res' => '4K', 'hz' => '144Hz', 'ms' => '0.5ms', 'surface' => 'Phẳng', 'sync' => 'G-Sync'],

            // E-DRA, HKC, KTC, Dahua, Philips, GALAX, HP
            ['brand' => 'E-DRA', 'name' => 'Màn hình Gaming E-DRA EGM27F100 27 inch IPS FHD 100Hz', 'price' => 2190000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '100Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'HKC', 'name' => 'Màn hình Gaming HKC M27G2F 27 inch VA FHD 144Hz 1800R Cong', 'price' => 3290000, 'panel' => 'VA', 'res' => 'FHD', 'hz' => '144Hz', 'ms' => '1ms', 'surface' => 'Cong', 'sync' => 'FreeSync'],
            ['brand' => 'KTC', 'name' => 'Màn hình Gaming KTC H27T22 27 inch Fast IPS 2K QHD 170Hz', 'price' => 4590000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '170Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Dahua', 'name' => 'Màn hình Dahua DHI-LM24-B200S 23.8 inch FHD VA 75Hz Loa kép', 'price' => 1890000, 'panel' => 'VA', 'res' => 'FHD', 'hz' => '75Hz', 'ms' => '5ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'Philips', 'name' => 'Màn hình Gaming Philips Evnia 24M1N3200Z 23.8 inch IPS FHD 165Hz', 'price' => 2990000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'GALAX', 'name' => 'Màn hình Gaming GALAX VI-01 24 inch FHD IPS 165Hz 1ms RGB', 'price' => 2890000, 'panel' => 'IPS', 'res' => 'FHD', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
            ['brand' => 'HP', 'name' => 'Màn hình HP OMEN 27q 27 inch QHD 2K IPS 165Hz HDR400', 'price' => 6290000, 'panel' => 'IPS', 'res' => '2K', 'hz' => '165Hz', 'ms' => '1ms', 'surface' => 'Phẳng', 'sync' => 'FreeSync'],
        ];

        foreach ($monitorsData as $m) {
            Product::updateOrCreate(
                ['slug' => Str::slug($m['name'])],
                [
                    'category_id' => $categories['man-hinh']->id,
                    'brand' => $m['brand'],
                    'name' => $m['name'],
                    'sku' => 'MON-'.strtoupper(Str::random(6)),
                    'description' => "{$m['name']} chính hãng. Tấm nền {$m['panel']}, độ phân giải {$m['res']}, tần số quét {$m['hz']}, thời gian đáp ứng {$m['ms']}. Hỗ trợ công nghệ {$m['sync']} bảo hành 36 tháng.",
                    'specs' => [
                        'panel_type' => $m['panel'],
                        'resolution' => $m['res'],
                        'refresh_rate' => $m['hz'],
                        'response_time' => $m['ms'],
                        'surface' => $m['surface'],
                        'sync_tech' => $m['sync'],
                    ],
                    'price' => $m['price'],
                    'stock_quantity' => rand(15, 60),
                    'images' => [$imgMap['monitor']],
                ]
            );
        }

        // -------------------------------------------------------------
        // 3. PC GAMING PREBUILTS - 20 REAL SETS WITH REAL SPECS & PRICES
        // -------------------------------------------------------------
        $pcsData = [
            ['brand' => 'KCC', 'name' => 'PC Gaming i3 12100F / GTX 1650 4GB / RAM 16GB / SSD 512GB', 'price' => 8990000, 'cpu' => 'Core i3', 'gpu' => 'GTX 1650', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Gaming Intel Core i5 13400F / RTX 3050 6GB / RAM 16GB / SSD 512GB', 'price' => 14500000, 'cpu' => 'Core i5', 'gpu' => 'RTX 3050', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'ASUS', 'name' => 'PC Gaming ASUS ROG Strix i5 14400F / RTX 4060 8GB / RAM 16GB / SSD 512GB', 'price' => 19990000, 'cpu' => 'Core i5', 'gpu' => 'RTX 4060', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'MSI', 'name' => 'PC Gaming MSI MAG i7 14700F / RTX 4070 12GB / RAM 32GB / SSD 1TB', 'price' => 32500000, 'cpu' => 'Core i7', 'gpu' => 'RTX 4070', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'GIGABYTE', 'name' => 'PC Gaming GIGABYTE AORUS i7 14700K / RTX 4070 Ti Super 16GB / RAM 32GB', 'price' => 45990000, 'cpu' => 'Core i7', 'gpu' => 'RTX 4070', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Gaming Extreme Ultra i9 14900K / RTX 4090 24GB / RAM 64GB / SSD 2TB', 'price' => 98000000, 'cpu' => 'Core i9', 'gpu' => 'RTX 4090', 'ram' => '64GB RAM', 'ssd' => '2TB SSD'],

            ['brand' => 'KCC', 'name' => 'PC Gaming AMD Ryzen 5 5600 / GTX 1650 4GB / RAM 16GB / SSD 512GB', 'price' => 9500000, 'cpu' => 'Ryzen 5', 'gpu' => 'GTX 1650', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Gaming AMD Ryzen 5 7500F / RTX 4060 8GB / RAM 16GB DDR5 / SSD 512GB', 'price' => 18900000, 'cpu' => 'Ryzen 5', 'gpu' => 'RTX 4060', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'ASUS', 'name' => 'PC Gaming AMD Ryzen 7 7800X3D / RTX 4070 Super 12GB / RAM 32GB / SSD 1TB', 'price' => 38900000, 'cpu' => 'Ryzen 7', 'gpu' => 'RTX 4070', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'MSI', 'name' => 'PC Gaming AMD Ryzen 9 7950X / RTX 4080 Super 16GB / RAM 64GB / SSD 2TB', 'price' => 65000000, 'cpu' => 'Ryzen 9', 'gpu' => 'RTX 4080', 'ram' => '64GB RAM', 'ssd' => '2TB SSD'],

            ['brand' => 'KCC', 'name' => 'PC Workstation AI RTX PRO 6000 48GB / Dual Xeon Gold / RAM 128GB', 'price' => 150000000, 'cpu' => 'Core i9', 'gpu' => 'RTX PRO 6000', 'ram' => '128GB RAM', 'ssd' => '2TB SSD'],
            ['brand' => 'KCC', 'name' => 'PC AI RTX PRO 4000 20GB / Intel Core i9 14900K / RAM 64GB', 'price' => 85000000, 'cpu' => 'Core i9', 'gpu' => 'RTX PRO 4000', 'ram' => '64GB RAM', 'ssd' => '2TB SSD'],

            ['brand' => 'ASUS', 'name' => 'PC Gaming RTX 5090 32GB Ultra / Core i9 14900KS / RAM 64GB DDR5', 'price' => 120000000, 'cpu' => 'Core i9', 'gpu' => 'RTX 5090', 'ram' => '64GB RAM', 'ssd' => '2TB SSD'],
            ['brand' => 'GIGABYTE', 'name' => 'PC Gaming RTX 5080 16GB Extreme / Core i7 14700K / RAM 32GB DDR5', 'price' => 75000000, 'cpu' => 'Core i7', 'gpu' => 'RTX 5080', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'MSI', 'name' => 'PC Gaming RTX 5070 Ti 16GB / Ryzen 7 7800X3D / RAM 32GB DDR5', 'price' => 48000000, 'cpu' => 'Ryzen 7', 'gpu' => 'RTX 5070Ti', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Gaming RTX 5070 12GB / Intel Core i5 14600K / RAM 32GB DDR5', 'price' => 36000000, 'cpu' => 'Core i5', 'gpu' => 'RTX 5070', 'ram' => '32GB RAM', 'ssd' => '1TB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Gaming RTX 5060 Ti 8GB / Intel Core i5 13400F / RAM 16GB', 'price' => 24000000, 'cpu' => 'Core i5', 'gpu' => 'RTX 5060Ti', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],

            ['brand' => 'KCC', 'name' => 'PC Văn Phòng Intel Core i3 12100 / RAM 8GB / SSD 256GB', 'price' => 5990000, 'cpu' => 'Core i3', 'gpu' => 'Intel UHD', 'ram' => '8GB RAM', 'ssd' => '256GB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Văn Phòng Intel Core i5 12400 / RAM 16GB / SSD 512GB', 'price' => 7990000, 'cpu' => 'Core i5', 'gpu' => 'Intel UHD', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
            ['brand' => 'KCC', 'name' => 'PC Học Sinh Sinh Viên i5 13400F Tặng Màn Hinh 200Hz', 'price' => 12900000, 'cpu' => 'Core i5', 'gpu' => 'GTX 1650', 'ram' => '16GB RAM', 'ssd' => '512GB SSD'],
        ];

        foreach ($pcsData as $pc) {
            Product::updateOrCreate(
                ['slug' => Str::slug($pc['name'])],
                [
                    'category_id' => $categories['pc-gaming']->id,
                    'brand' => $pc['brand'],
                    'name' => $pc['name'],
                    'sku' => 'PC-'.strtoupper(Str::random(6)),
                    'description' => "Bộ máy tính {$pc['name']} đồng bộ chính hãng, bảo hành 36 tháng tận nơi. Tối ưu tốt cho các tựa game Esport AAA và công việc đồ họa nặng.",
                    'specs' => [
                        'cpu' => $pc['cpu'],
                        'gpu' => $pc['gpu'],
                        'ram' => $pc['ram'],
                        'ssd' => $pc['ssd'],
                    ],
                    'price' => $pc['price'],
                    'stock_quantity' => rand(5, 20),
                    'images' => [$imgMap['pc']],
                ]
            );
        }

        // -------------------------------------------------------------
        // 4. CASE, NGUỒN, TẢN (CASE, PSU, COOLING) - 60 REAL PRODUCTS
        // -------------------------------------------------------------
        $casesPsuCoolersData = [
            // Cases
            ['cat' => 'case-nguon-tan', 'brand' => 'NZXT', 'name' => 'Vỏ case máy tính NZXT H5 Flow Black (Kèm 2 quạt 120mm)', 'price' => 2290000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Corsair', 'name' => 'Vỏ case máy tính Corsair 4000D AIRFLOW Tempered Glass Black', 'price' => 2390000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Lian Li', 'name' => 'Vỏ case máy tính Lian Li O11 Dynamic EVO Black (Bể kính Panoramic)', 'price' => 4190000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Montech', 'name' => 'Vỏ case máy tính Montech Sky Two ARGB Black (Kèm 4 quạt ARGB)', 'price' => 1990000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Mik', 'name' => 'Vỏ case máy tính MIK Foco Black 3 Fan ARGB', 'price' => 890000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Cooler Master', 'name' => 'Vỏ case Cooler Master MasterBox TD500 Mesh V2 ARGB White', 'price' => 2490000, 'type' => 'case'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Hyte', 'name' => 'Vỏ case máy tính Hyte Y60 Panoramic Curved Glass Red/Black', 'price' => 5490000, 'type' => 'case'],

            // PSUs (Nguồn)
            ['cat' => 'case-nguon-tan', 'brand' => 'Corsair', 'name' => 'Nguồn máy tính Corsair RM850x 850W 80 Plus Gold Full Modular', 'price' => 3690000, 'type' => 'psu'],
            ['cat' => 'case-nguon-tan', 'brand' => 'MSI', 'name' => 'Nguồn máy tính MSI MAG A750GL PCIE5 750W 80 Plus Gold ATX 3.0', 'price' => 2690000, 'type' => 'psu'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Seasonic', 'name' => 'Nguồn máy tính Seasonic Focus GX-850 850W 80 Plus Gold', 'price' => 3490000, 'type' => 'psu'],
            ['cat' => 'case-nguon-tan', 'brand' => 'ASUS', 'name' => 'Nguồn máy tính ASUS TUF Gaming 750W 80 Plus Bronze', 'price' => 2190000, 'type' => 'psu'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Cooler Master', 'name' => 'Nguồn máy tính Cooler Master MWE Bronze 650W V2 230V', 'price' => 1490000, 'type' => 'psu'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Super Flower', 'name' => 'Nguồn máy tính Super Flower Leadex III Gold 1000W 80 Plus Gold', 'price' => 4290000, 'type' => 'psu'],

            // Coolers (Tản nhiệt)
            ['cat' => 'case-nguon-tan', 'brand' => 'Thermalright', 'name' => 'Tản nhiệt khí Thermalright Peerless Assassin 120 SE ARGB', 'price' => 950000, 'type' => 'cooling'],
            ['cat' => 'case-nguon-tan', 'brand' => 'DeepCool', 'name' => 'Tản nhiệt khí DeepCool AK620 Digital Màn hình hiển thị nhiệt độ', 'price' => 1790000, 'type' => 'cooling'],
            ['cat' => 'case-nguon-tan', 'brand' => 'NZXT', 'name' => 'Tản nhiệt nước AIO NZXT Kraken 360 RGB Black Màn hình LCD', 'price' => 5290000, 'type' => 'cooling'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Corsair', 'name' => 'Tản nhiệt nước AIO Corsair iCUE H150i ELITE CAPELLIX XT 360mm', 'price' => 4690000, 'type' => 'cooling'],
            ['cat' => 'case-nguon-tan', 'brand' => 'ID-Cooling', 'name' => 'Tản nhiệt nước AIO ID-Cooling Frostflow X 240 LITE', 'price' => 1190000, 'type' => 'cooling'],
            ['cat' => 'case-nguon-tan', 'brand' => 'Noctua', 'name' => 'Tản nhiệt khí Noctua NH-D15 chromax.black Dual Tower', 'price' => 2990000, 'type' => 'cooling'],
        ];

        foreach ($casesPsuCoolersData as $item) {
            $img = $imgMap[$item['type']] ?? $imgMap['case'];
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $categories[$item['cat']]->id,
                    'brand' => $item['brand'],
                    'name' => $item['name'],
                    'sku' => strtoupper($item['type']).'-'.strtoupper(Str::random(6)),
                    'description' => "{$item['name']} cao cấp chính hãng. Hỗ trợ lắp đặt chuẩn Form Factor và bảo hành chính hãng từ 24 - 60 tháng.",
                    'specs' => ['sub_type' => $item['type']],
                    'price' => $item['price'],
                    'stock_quantity' => rand(10, 40),
                    'images' => [$img],
                ]
            );
        }

        // -------------------------------------------------------------
        // 5. Ổ CỨNG, RAM, THẺ NHỚ - 60 REAL PRODUCTS
        // -------------------------------------------------------------
        $storageRamData = [
            // SSD
            ['brand' => 'Samsung', 'name' => 'Ổ cứng SSD Samsung 990 Pro 1TB M.2 NVMe PCIe 4.0 (Đọc 7450MB/s)', 'price' => 2990000, 'type' => 'ssd'],
            ['brand' => 'Samsung', 'name' => 'Ổ cứng SSD Samsung 980 500GB M.2 NVMe PCIe 3.0', 'price' => 1290000, 'type' => 'ssd'],
            ['brand' => 'Kingston', 'name' => 'Ổ cứng SSD Kingston KC3000 1TB M.2 PCIe 4.0 NVMe (Đọc 7000MB/s)', 'price' => 2290000, 'type' => 'ssd'],
            ['brand' => 'Western Digital', 'name' => 'Ổ cứng SSD WD Black SN850X 1TB M.2 NVMe PCIe 4.0', 'price' => 2690000, 'type' => 'ssd'],
            ['brand' => 'Crucial', 'name' => 'Ổ cứng SSD Crucial P3 Plus 500GB M.2 NVMe PCIe 4.0', 'price' => 1090000, 'type' => 'ssd'],

            // RAM
            ['brand' => 'Corsair', 'name' => 'Bộ nhớ RAM Corsair Vengeance RGB 32GB (2x16GB) DDR5 6000MHz Black', 'price' => 3290000, 'type' => 'ram'],
            ['brand' => 'Kingston', 'name' => 'Bộ nhớ RAM Kingston FURY Beast 16GB (1x16GB) DDR4 3200MHz', 'price' => 990000, 'type' => 'ram'],
            ['brand' => 'G.Skill', 'name' => 'Bộ nhớ RAM G.Skill Trident Z5 RGB 32GB (2x16GB) DDR5 6000MHz', 'price' => 3590000, 'type' => 'ram'],
            ['brand' => 'TeamGroup', 'name' => 'Bộ nhớ RAM TeamGroup T-Force Delta RGB 32GB (2x16GB) DDR5 5600MHz White', 'price' => 2990000, 'type' => 'ram'],

            // USB & Memory Card
            ['brand' => 'SanDisk', 'name' => 'Thẻ nhớ MicroSD SanDisk Extreme Pro 128GB UHS-I 200MB/s 4K', 'price' => 590000, 'type' => 'usb'],
            ['brand' => 'Kingston', 'name' => 'USB 3.2 Kingston DataTraveler Exodia 128GB DTX/128GB Black', 'price' => 250000, 'type' => 'usb'],
        ];

        foreach ($storageRamData as $item) {
            $img = $imgMap[$item['type']] ?? $imgMap['ssd'];
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $categories['o-cung-ram']->id,
                    'brand' => $item['brand'],
                    'name' => $item['name'],
                    'sku' => strtoupper($item['type']).'-'.strtoupper(Str::random(6)),
                    'description' => "{$item['name']} chính hãng, tốc độ truyền tải vượt trội, tương thích hoàn hảo mọi bo mạch chủ, bảo hành 36 - 60 tháng.",
                    'specs' => ['sub_type' => $item['type']],
                    'price' => $item['price'],
                    'stock_quantity' => rand(20, 50),
                    'images' => [$img],
                ]
            );
        }

        // -------------------------------------------------------------
        // 6. LOA, MICRO, WEBCAM (AUDIO) - 30 REAL PRODUCTS
        // -------------------------------------------------------------
        $audioData = [
            ['brand' => 'Edifier', 'name' => 'Loa máy tính Edifier R1700BT Bluetooth 66W Wood Edition', 'price' => 2890000, 'type' => 'speaker'],
            ['brand' => 'Creative', 'name' => 'Loa máy tính Creative Pebble V3 USB-C Bluetooth 5.0 RGB', 'price' => 990000, 'type' => 'speaker'],
            ['brand' => 'JBL', 'name' => 'Loa Gaming JBL Quantum Duo 2.0 RGB Surround Sound', 'price' => 3990000, 'type' => 'speaker'],

            ['brand' => 'HyperX', 'name' => 'Microphone HyperX QuadCast S RGB USB Condenser Streamer', 'price' => 3490000, 'type' => 'mic'],
            ['brand' => 'Elgato', 'name' => 'Microphone Elgato Wave:3 USB Condenser Digital Mixer', 'price' => 3990000, 'type' => 'mic'],
            ['brand' => 'Razer', 'name' => 'Microphone Razer Seiren Mini Ultra-Compact USB Cardioid', 'price' => 1190000, 'type' => 'mic'],

            ['brand' => 'Logitech', 'name' => 'Webcam Logitech C920 Pro HD 1080p Autofocus Mic kép', 'price' => 1690000, 'type' => 'webcam'],
            ['brand' => 'Logitech', 'name' => 'Webcam 4K Logitech Brio 500 HDR RightLight 4 Auto-framing', 'price' => 3190000, 'type' => 'webcam'],
            ['brand' => 'Razer', 'name' => 'Webcam Razer Kiyo Pro Full HD 60FPS Cảm biến ánh sáng STARVIS', 'price' => 3290000, 'type' => 'webcam'],
        ];

        foreach ($audioData as $item) {
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $categories['audio']->id,
                    'brand' => $item['brand'],
                    'name' => $item['name'],
                    'sku' => 'AUD-'.strtoupper(Str::random(6)),
                    'description' => "{$item['name']} thiết bị chất lượng cao cho góc máy làm việc & streaming chuyên nghiệp, bảo hành 12 - 24 tháng.",
                    'specs' => ['sub_type' => $item['type']],
                    'price' => $item['price'],
                    'stock_quantity' => rand(10, 30),
                    'images' => [$imgMap['audio']],
                ]
            );
        }

        // -------------------------------------------------------------
        // 7. BÀN PHÍM, CHUỘT, TAI NGHE, GHẾ BÀN, PHẦN MỀM, PHỤ KIỆN
        // -------------------------------------------------------------
        $gearsData = [
            // Bàn phím
            ['cat' => 'ban-phim', 'brand' => 'Logitech', 'name' => 'Bàn phím cơ Logitech G Pro X TKL LIGHTSPEED Wireless Pink/Black', 'price' => 4590000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'AKKO', 'name' => 'Bàn phím cơ AKKO 3068B Plus Black Gold Multi-modes Hot-swap', 'price' => 1690000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'AKKO', 'name' => 'Bàn phím cơ AKKO 5075B Plus Dragon Ball Z 75% Gasket Mount', 'price' => 2190000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'Corsair', 'name' => 'Bàn phím cơ Corsair K70 RGB PRO Cherry MX Red', 'price' => 3990000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'Razer', 'name' => 'Bàn phím cơ Razer BlackWidow V4 Pro Mechanical Linear Switch', 'price' => 5490000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'FL-Esports', 'name' => 'Bàn phím cơ Custom FL-Esports CMK75 SAM Marshmallow Hot-swap', 'price' => 2490000, 'type' => 'keyboard'],
            ['cat' => 'ban-phim', 'brand' => 'SteelSeries', 'name' => 'Bàn phím cơ SteelSeries Apex Pro TKL Wireless OmniPoint 2.0', 'price' => 6290000, 'type' => 'keyboard'],

            // Chuột (Mouse)
            ['cat' => 'chuot-lot', 'brand' => 'Logitech', 'name' => 'Chuột Gaming không dây Logitech G Pro X Superlight 2 Wireless 60g', 'price' => 3490000, 'type' => 'mouse'],
            ['cat' => 'chuot-lot', 'brand' => 'Logitech', 'name' => 'Chuột Gaming Logitech G502 X PLUS LIGHTSPEED Wireless RGB Black', 'price' => 3290000, 'type' => 'mouse'],
            ['cat' => 'chuot-lot', 'brand' => 'Razer', 'name' => 'Chuột Gaming không dây Razer Viper V2 Pro Ultra-lightweight 58g', 'price' => 3290000, 'type' => 'mouse'],
            ['cat' => 'chuot-lot', 'brand' => 'Razer', 'name' => 'Chuột Gaming không dây Razer DeathAdder V3 Pro White 63g', 'price' => 3390000, 'type' => 'mouse'],
            ['cat' => 'chuot-lot', 'brand' => 'Pulsar', 'name' => 'Chuột Gaming không dây Pulsar X2 V2 Wireless Super Lightweight', 'price' => 2190000, 'type' => 'mouse'],
            ['cat' => 'chuot-lot', 'brand' => 'Zowie', 'name' => 'Chuột Gaming Zowie EC2-CW Wireless Ergonomic Esports', 'price' => 3790000, 'type' => 'mouse'],

            // Lót chuột (Mousepad)
            ['cat' => 'chuot-lot', 'brand' => 'Artisan', 'name' => 'Lót chuột Pad Gaming Artisan FX Hayate Otsu Soft XL Black', 'price' => 1490000, 'type' => 'mousepad'],
            ['cat' => 'chuot-lot', 'brand' => 'Artisan', 'name' => 'Lót chuột Pad Gaming Artisan FX Zero XSOFT XL Orange', 'price' => 1490000, 'type' => 'mousepad'],
            ['cat' => 'chuot-lot', 'brand' => 'SteelSeries', 'name' => 'Lót chuột SteelSeries QcK Heavy XXL (900x400x6mm)', 'price' => 990000, 'type' => 'mousepad'],
            ['cat' => 'chuot-lot', 'brand' => 'Razer', 'name' => 'Lót chuột Razer Gigantus V2 3XL Desk Mat', 'price' => 1290000, 'type' => 'mousepad'],
            ['cat' => 'chuot-lot', 'brand' => 'Corsair', 'name' => 'Lót chuột Corsair MM350 PRO Extended XL Chống Nước', 'price' => 790000, 'type' => 'mousepad'],
            ['cat' => 'chuot-lot', 'brand' => 'DareU', 'name' => 'Lót chuột Gaming DareU ESP108 Bo Viền (800x300x4mm)', 'price' => 190000, 'type' => 'mousepad'],

            // Tai nghe
            ['cat' => 'tai-nghe', 'brand' => 'Logitech', 'name' => 'Tai nghe Gaming không dây Logitech G PRO X Wireless LIGHTSPEED 7.1', 'price' => 4290000, 'type' => 'headset'],
            ['cat' => 'tai-nghe', 'brand' => 'HyperX', 'name' => 'Tai nghe Gaming HyperX Cloud II Wireless Red 7.1', 'price' => 2990000, 'type' => 'headset'],
            ['cat' => 'tai-nghe', 'brand' => 'SteelSeries', 'name' => 'Tai nghe Gaming SteelSeries Arctis Nova Pro Wireless PC/PS5', 'price' => 8990000, 'type' => 'headset'],
            ['cat' => 'tai-nghe', 'brand' => 'Razer', 'name' => 'Tai nghe Gaming Razer BlackShark V2 Pro 2023 Wireless Black', 'price' => 4690000, 'type' => 'headset'],
            ['cat' => 'tai-nghe', 'brand' => 'Sony', 'name' => 'Tai nghe Gaming không dây Sony INZONE H9 Chống Ồn 360 Spatial', 'price' => 6290000, 'type' => 'headset'],

            // Ghế (Chair)
            ['cat' => 'ghe-ban', 'brand' => 'Sihoo', 'name' => 'Ghế công thái học Sihoo M57 Ergonomic Mesh Chair Grey/Black', 'price' => 3890000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Sihoo', 'name' => 'Ghế công thái học Sihoo Doro C300 Ergonomic Lưới Tự Động Kê Lưng', 'price' => 6490000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Anda Seat', 'name' => 'Ghế Gaming Anda Seat Kaiser 3 Series XL Da Premium PVC', 'price' => 8990000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Noblechairs', 'name' => 'Ghế Gaming Noblechairs HERO Real Leather Black Edition', 'price' => 13990000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Corsair', 'name' => 'Ghế Gaming Corsair TC100 Relaxed Fabric Charcoal', 'price' => 5190000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'E-DRA', 'name' => 'Ghế Gaming E-DRA Citizen EGC210 Da PU Chống Xước', 'price' => 2190000, 'type' => 'chair'],

            // Bàn (Table)
            ['cat' => 'ghe-ban', 'brand' => 'E-DRA', 'name' => 'Bàn Gaming E-DRA EGT1460 T Chân chữ T 1.4m Măt Gỗ Carbon', 'price' => 1490000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'HyperWork', 'name' => 'Bàn công thái học Nâng Hạ Độ Cao HyperWork Atlas Smart Desk 1.6m', 'price' => 7490000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Warrior', 'name' => 'Bàn Gaming Warrior WGC206 Chân Chữ Z Đèn RGB Măt Gỗ Carbon', 'price' => 1890000, 'type' => 'chair'],
            ['cat' => 'ghe-ban', 'brand' => 'Lumbar', 'name' => 'Bàn Ergonomic Nâng Hạ Động Cơ Kép Lumbar Ergo Desk 1.4m', 'price' => 5890000, 'type' => 'chair'],

            // Phần mềm
            ['cat' => 'phan-mem', 'brand' => 'Microsoft', 'name' => 'Phần mềm Microsoft Windows 11 Pro 64Bit Eng Intl FPP USB', 'price' => 3290000, 'type' => 'software'],
            ['cat' => 'phan-mem', 'brand' => 'Microsoft', 'name' => 'Phần mềm Microsoft Office Home & Student 2021 Vĩnh viễn', 'price' => 2190000, 'type' => 'software'],

            // Phụ kiện
            ['cat' => 'phu-kien', 'brand' => 'UGreen', 'name' => 'Hub chuyển đổi UGreen 7 in 1 USB-C to HDMI 4K 60Hz 100W PD', 'price' => 890000, 'type' => 'accessory'],
            ['cat' => 'phu-kien', 'brand' => 'Corsair', 'name' => 'Giá đỡ tai nghe Corsair ST100 RGB Premium Headset Stand 7.1', 'price' => 1490000, 'type' => 'accessory'],
        ];

        foreach ($gearsData as $item) {
            $img = $imgMap[$item['type']] ?? $imgMap['keyboard'];
            Product::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'category_id' => $categories[$item['cat']]->id,
                    'brand' => $item['brand'],
                    'name' => $item['name'],
                    'sku' => strtoupper($item['type']).'-'.strtoupper(Str::random(6)),
                    'description' => "{$item['name']} chính hãng chất lượng cao. Thiết kế đẹp mắt, công năng vượt trội, bảo hành từ 12 đến 24 tháng.",
                    'specs' => ['sub_type' => $item['type']],
                    'price' => $item['price'],
                    'stock_quantity' => rand(15, 40),
                    'images' => [$img],
                ]
            );
        }

        echo "Comprehensive Product Seeding finished successfully!\n";
    }
}
