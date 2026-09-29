<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo các danh mục chính chuẩn PC/Laptop Store
        $categoriesData = [
            ['name' => 'Laptop', 'slug' => 'laptop', 'description' => 'Các dòng laptop học tập, văn phòng và đồ họa'],
            ['name' => 'Laptop Gaming', 'slug' => 'laptop-gaming', 'description' => 'Laptop gaming cấu hình cao, màn hình tần số quét lớn'],
            ['name' => 'PC Gaming', 'slug' => 'pc-gaming', 'description' => 'Bộ máy tính PC Gaming lắp sẵn hiệu năng cao'],
            ['name' => 'Main, CPU, VGA', 'slug' => 'main-cpu-vga', 'description' => 'Linh kiện cốt lõi: Bo mạch chủ, Vi xử lý, Card màn hình'],
            ['name' => 'Case, Nguồn, Tản', 'slug' => 'case-nguon-tan', 'description' => 'Vỏ máy tính, Nguồn công suất thực và Tản nhiệt nước/khí'],
            ['name' => 'Ổ cứng, RAM', 'slug' => 'o-cung-ram', 'description' => 'RAM DDR4/DDR5 và Ổ cứng SSD NVMe tốc độ cao'],
            ['name' => 'Màn hình', 'slug' => 'man-hinh', 'description' => 'Màn hình máy tính Gaming 144Hz - 240Hz, IPS 2K/4K'],
            ['name' => 'Bàn phím', 'slug' => 'ban-phim', 'description' => 'Bàn phím cơ Wireless, Custom Hot-swap'],
            ['name' => 'Chuột + Lót', 'slug' => 'chuot-lot', 'description' => 'Chuột gaming không dây, lót chuột bo viền'],
            ['name' => 'Tai Nghe', 'slug' => 'tai-nghe', 'description' => 'Tai nghe Gaming 7.1 surround sound'],
            ['name' => 'Ghế - Bàn', 'slug' => 'ghe-ban', 'description' => 'Ghế công thái học và bàn gaming'],
            ['name' => 'Phần mềm', 'slug' => 'phan-mem', 'description' => 'Hệ điều hành Windows và phần mềm bản quyền'],
            ['name' => 'Phụ kiện', 'slug' => 'phu-kien', 'description' => 'Dây cáp, Hub USB, giá đỡ tai nghe'],
            ['name' => 'Thu cũ đổi mới', 'slug' => 'thu-cu-doi-moi', 'description' => 'Dịch vụ thu cũ đổi mới linh kiện PC'],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::firstOrCreate(
                ['slug' => $cData['slug']],
                $cData
            );
        }

        // 2. Định nghĩa dữ liệu linh kiện mẫu từ các Hãng hàng đầu
        $brands = ['ASUS', 'MSI', 'Gigabyte', 'Intel', 'AMD', 'NVIDIA', 'Corsair', 'Kingston', 'Samsung', 'Logitech', 'Razer', 'Dell', 'LG', 'Acer', 'Lenovo', 'Keychron', 'Sihoo'];
        
        $images = [
            'pc' => [
                'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=500',
                'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=500',
                'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=500',
                'https://images.unsplash.com/photo-1593640408182-31c228f8a9e3?w=500',
            ],
            'laptop' => [
                'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=500',
                'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=500',
                'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500',
                'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500',
            ],
            'component' => [
                'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=500',
                'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=500',
            ],
            'monitor' => [
                'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500',
            ],
            'gear' => [
                'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?w=500',
                'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500',
            ],
            'chair' => [
                'https://images.unsplash.com/photo-1580481072645-022f9a6d8310?w=500',
            ]
        ];

        // Tạo 200 linh kiện phong phú
        $productsToInsert = [];
        
        $catSlugs = array_keys($categories);
        $count = 1;

        // Sinh 200 linh kiện chuẩn mã SKU, thông số specs thực tế
        for ($i = 1; $i <= 200; $i++) {
            $catSlug = $catSlugs[$i % count($catSlugs)];
            $brand = $brands[$i % count($brands)];

            $name = '';
            $price = 0;
            $specs = [];
            $img = '';

            switch ($catSlug) {
                case 'laptop-gaming':
                    $gpus = ['RTX 3050 4GB', 'RTX 4050 6GB', 'RTX 4060 8GB', 'RTX 4070 8GB', 'RTX 4080 12GB'];
                    $cpus = ['Intel Core i5-13500H', 'Intel Core i7-13700HX', 'AMD Ryzen 7 7735HS', 'AMD Ryzen 9 7945HX'];
                    $name = "Laptop Gaming {$brand} " . ($i % 2 == 0 ? 'TUF Gaming' : 'ROG Strix') . " V{$i} (" . $gpus[$i % count($gpus)] . ")";
                    $price = rand(18, 55) * 1000000 + 99000;
                    $specs = [
                        'cpu' => $cpus[$i % count($cpus)],
                        'ram' => ($i % 2 == 0 ? '16GB' : '32GB') . ' DDR5',
                        'ssd' => ($i % 3 == 0 ? '1TB' : '512GB') . ' NVMe PCIe 4.0',
                        'gpu' => $gpus[$i % count($gpus)],
                        'screen' => '15.6" ' . ($i % 2 == 0 ? '144Hz' : '165Hz IPS')
                    ];
                    $img = $images['laptop'][$i % count($images['laptop'])];
                    break;

                case 'laptop':
                    $name = "Laptop {$brand} Zenbook / Aspire Slim 14 (V{$i})";
                    $price = rand(12, 28) * 1000000 + 49000;
                    $specs = [
                        'cpu' => 'Intel Core i5-1335U / Apple M2',
                        'ram' => '16GB LPDDR5',
                        'ssd' => '512GB SSD',
                        'screen' => '14" OLED 2.8K'
                    ];
                    $img = $images['laptop'][$i % count($images['laptop'])];
                    break;

                case 'pc-gaming':
                    $cpus = ['Intel Core i5-12400F', 'Intel Core i7-14700F', 'AMD Ryzen 7 7800X3D', 'Intel Core i9-14900K'];
                    $gpus = ['RTX 3060 12GB', 'RTX 4060 Ti 8GB', 'RTX 4070 SUPER 12GB', 'RTX 5070 Ti 16GB', 'RTX 5080 16GB'];
                    $name = "PC Gaming PCShop Ultra V{$i} (" . $gpus[$i % count($gpus)] . ")";
                    $price = rand(15, 85) * 1000000 + 99000;
                    $specs = [
                        'cpu' => $cpus[$i % count($cpus)],
                        'ram' => '16GB - 32GB DDR5',
                        'ssd' => '512GB - 1TB Gen4',
                        'gpu' => $gpus[$i % count($gpus)]
                    ];
                    $img = $images['pc'][$i % count($images['pc'])];
                    break;

                case 'main-cpu-vga':
                    if ($i % 3 == 0) {
                        $name = "Vi Xử Lý CPU {$brand} Core " . ($i % 2 == 0 ? 'i5-13400F' : 'i7-14700K');
                        $price = rand(4, 11) * 1000000 + 90000;
                        $specs = ['socket' => 'LGA 1700 / AM5', 'cores' => '10-20 Cores', 'base_clock' => '3.4 GHz'];
                    } else if ($i % 3 == 1) {
                        $name = "Card Màn Hình {$brand} GeForce RTX " . ($i % 2 == 0 ? '4060 Ti 8GB' : '4070 SUPER 12GB');
                        $price = rand(8, 25) * 1000000 + 90000;
                        $specs = ['vram' => '8GB - 12GB GDDR6X', 'bus' => '192-bit'];
                    } else {
                        $name = "Bo Mạch Chủ Mainboard {$brand} " . ($i % 2 == 0 ? 'B760M-PLUS WIFI' : 'Z790 GAMING X');
                        $price = rand(3, 8) * 1000000 + 50000;
                        $specs = ['chipset' => 'Intel B760 / Z790', 'form_factor' => 'ATX / Micro-ATX'];
                    }
                    $img = $images['component'][$i % count($images['component'])];
                    break;

                case 'case-nguon-tan':
                    $name = "{$brand} " . ($i % 2 == 0 ? 'Nguồn PC 750W 80 Plus Gold' : 'Tản Nhiệt Nước AIO 360mm RGB');
                    $price = rand(1, 4) * 1000000 + 50000;
                    $specs = ['efficiency' => '80 Plus Gold', 'warranty' => '60 tháng'];
                    $img = $images['component'][$i % count($images['component'])];
                    break;

                case 'o-cung-ram':
                    $name = "{$brand} " . ($i % 2 == 0 ? 'RAM Desktop DDR5 32GB (2x16GB) 6000MHz' : 'Ổ Cứng SSD NVMe Gen4 1TB 7300MB/s');
                    $price = rand(1, 4) * 1000000 + 20000;
                    $specs = ['speed' => '6000MHz / 7300MB/s', 'type' => 'DDR5 / PCIe 4.0'];
                    $img = $images['component'][$i % count($images['component'])];
                    break;

                case 'man-hinh':
                    $name = "Màn Hình {$brand} " . ($i % 2 == 0 ? '27" 240Hz IPS Gaming' : '32" 4K UHD OLED 144Hz');
                    $price = rand(4, 18) * 1000000 + 90000;
                    $specs = ['size' => '27" - 32"', 'refresh_rate' => '165Hz - 240Hz', 'panel' => 'IPS / OLED 1ms'];
                    $img = $images['monitor'][0];
                    break;

                case 'ban-phim':
                case 'chuot-lot':
                case 'tai-nghe':
                    $name = "{$brand} Gaming " . ($i % 2 == 0 ? 'Bàn phím cơ Hot-Swap Wireless' : 'Chuột Không Dây Ultra-light 60g');
                    $price = rand(8, 35) * 100000;
                    $specs = ['connectivity' => 'Bluetooth 5.2 / 2.4GHz', 'battery' => '90h'];
                    $img = $images['gear'][$i % count($images['gear'])];
                    break;

                default:
                    $name = "Linh Kiện Máy Tính {$brand} High-Performance Model #{$i}";
                    $price = rand(5, 50) * 100000;
                    $specs = ['warranty' => '24 tháng chính hãng'];
                    $img = $images['gear'][0];
                    break;
            }

            $sku = strtoupper(Str::slug($brand)) . "-PART-" . str_pad($i, 4, '0', STR_PAD_LEFT);
            $slug = Str::slug($name) . "-{$i}";

            Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $categories[$catSlug]->id,
                    'brand' => $brand,
                    'name' => $name,
                    'slug' => $slug,
                    'sku' => $sku,
                    'description' => "{$name} chính hãng bảo hành 24-36 tháng tại trung tâm ủy quyền.",
                    'price' => $price,
                    'stock_quantity' => rand(5, 50),
                    'specs' => $specs,
                    'images' => [$img]
                ]
            );
        }
    }
}
