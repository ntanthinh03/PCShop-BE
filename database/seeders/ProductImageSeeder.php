<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        Product::query()->with('category')->chunkById(100, function ($products): void {
            foreach ($products as $product) {
                $product->update([
                    'images' => [$this->imagePathFor($product)],
                ]);
            }
        });
    }

    private function imagePathFor(Product $product): string
    {
        $category = Str::lower($product->category?->slug ?? '');
        $name = Str::lower($product->name.' '.$product->brand.' '.$product->sku);

        return match (true) {
            Str::contains($category, 'laptop') => $this->laptopImage($name),
            $category === 'pc-gaming' => $this->pcImage($name),
            $category === 'main-cpu-vga' => $this->coreComponentImage($name),
            $category === 'case-nguon-tan' => $this->casePowerCoolingImage($name),
            $category === 'o-cung-ram' => $this->storageMemoryImage($name),
            $category === 'man-hinh' => $this->monitorImage($name),
            $category === 'ban-phim' => $this->keyboardImage($name),
            $category === 'chuot-lot' => $this->mouseImage($name),
            $category === 'tai-nghe' || $category === 'audio' => $this->audioImage($name),
            $category === 'ghe-ban' => 'images/components/chair/chair_sihoo_m57.jpg',
            default => 'images/components/pc_prebuilt/pc_gvn_i5_rtx3050.jpg',
        };
    }

    private function laptopImage(string $name): string
    {
        return Str::contains($name, ['asus', 'rog'])
            ? 'images/components/laptop/laptop_asus_rog_g16.jpg'
            : 'images/components/laptop/laptop_acer_nitro5.jpg';
    }

    private function pcImage(string $name): string
    {
        return match (true) {
            Str::contains($name, ['4080', '7800x3d']) => 'images/components/pc_prebuilt/pc_gvn_r7_rtx4080.jpg',
            Str::contains($name, ['4070', '14700']) => 'images/components/pc_prebuilt/pc_gvn_i7_rtx4070ti.jpg',
            default => 'images/components/pc_prebuilt/pc_gvn_i5_rtx3050.jpg',
        };
    }

    private function coreComponentImage(string $name): string
    {
        if (Str::contains($name, ['cpu', 'vi xử lý', 'processor', 'ryzen', 'core i'])) {
            return match (true) {
                Str::contains($name, ['7800', 'ryzen 7']) => 'images/components/cpu/cpu_ryzen7_7800x3d.jpg',
                Str::contains($name, ['ryzen', 'amd']) => 'images/components/cpu/cpu_ryzen5_5600x.jpg',
                Str::contains($name, ['i7', '14700']) => 'images/components/cpu/cpu_intel_i7_14700k.jpg',
                Str::contains($name, ['i5', '13400']) => 'images/components/cpu/cpu_intel_i5_13400f.jpg',
                default => 'images/components/cpu/cpu_intel_i3_12100f.jpg',
            };
        }

        if (Str::contains($name, ['card', 'vga', 'geforce', 'rtx', 'radeon', ' rx'])) {
            return match (true) {
                Str::contains($name, ['4070']) => 'images/components/vga/vga_asus_rtx4070_super.jpg',
                Str::contains($name, ['4060 ti']) => 'images/components/vga/vga_msi_rtx4060ti.jpg',
                Str::contains($name, ['4060']) => 'images/components/vga/vga_gigabyte_rtx4060.jpg',
                Str::contains($name, ['rx']) => 'images/components/vga/vga_sapphire_rx6600.jpg',
                default => 'images/components/vga/vga_asus_rtx3050.jpg',
            };
        }

        return match (true) {
            Str::contains($name, ['msi', 'b550']) => 'images/components/mainboard/mb_msi_b550_tomahawk.jpg',
            Str::contains($name, ['gigabyte', 'z790']) => 'images/components/mainboard/mb_gigabyte_z790_d5.jpg',
            Str::contains($name, ['b650']) => 'images/components/mainboard/mb_asus_tuf_b650.jpg',
            default => 'images/components/mainboard/mb_asus_h610m_d4.jpg',
        };
    }

    private function casePowerCoolingImage(string $name): string
    {
        if (Str::contains($name, ['nguồn', 'power', 'psu', 'w 80'])) {
            return match (true) {
                Str::contains($name, ['corsair']) => 'images/components/psu/psu_corsair_cv650.jpg',
                Str::contains($name, ['msi']) => 'images/components/psu/psu_msi_a750bn.jpg',
                default => 'images/components/psu/psu_superflower_850w.jpg',
            };
        }

        if (Str::contains($name, ['tản', 'aio', 'cooler', 'thermalright'])) {
            return Str::contains($name, ['aio', '360'])
                ? 'images/components/cooler/cooler_aio_thermalright_360.jpg'
                : 'images/components/cooler/cooler_thermalright_pa120.jpg';
        }

        return Str::contains($name, ['sama'])
            ? 'images/components/case/case_sama_3502.jpg'
            : 'images/components/case/case_nzxt_h5_flow.jpg';
    }

    private function storageMemoryImage(string $name): string
    {
        if (Str::contains($name, ['ram', 'memory', 'ddr'])) {
            return Str::contains($name, ['ddr5', '32gb'])
                ? 'images/components/ram/ram_corsair_ddr5_32gb.jpg'
                : 'images/components/ram/ram_kingston_ddr4_16gb.jpg';
        }

        if (Str::contains($name, ['hdd', 'hard drive'])) {
            return 'images/components/hdd/hdd_wd_blue_1tb.jpg';
        }

        return Str::contains($name, ['samsung', '980'])
            ? 'images/components/ssd/ssd_samsung_980pro_1tb.jpg'
            : 'images/components/ssd/ssd_kingston_nv2_1tb.jpg';
    }

    private function monitorImage(string $name): string
    {
        return match (true) {
            Str::contains($name, ['dell']) => 'images/components/monitor/monitor_dell_u2723qe.jpg',
            Str::contains($name, ['lg']) => 'images/components/monitor/monitor_lg_27gq50f.jpg',
            default => 'images/components/monitor/monitor_asus_vg249q3a.jpg',
        };
    }

    private function keyboardImage(string $name): string
    {
        return match (true) {
            Str::contains($name, ['corsair']) => 'images/components/keyboard/kb_corsair_k70_pro.jpg',
            Str::contains($name, ['keychron']) => 'images/components/keyboard/kb_keychron_k2_pro.jpg',
            default => 'images/components/keyboard/kb_akko_3068b.jpg',
        };
    }

    private function mouseImage(string $name): string
    {
        return match (true) {
            Str::contains($name, ['razer']) => 'images/components/mouse/mouse_razer_deathadder_v3.jpg',
            Str::contains($name, ['logitech']) => 'images/components/mouse/mouse_logitech_g102.jpg',
            default => 'images/components/mouse/mouse_logitech_superlight2.jpg',
        };
    }

    private function audioImage(string $name): string
    {
        return match (true) {
            Str::contains($name, ['speaker', 'loa', 'edifier']) => 'images/components/headset_speaker/speaker_edifier_r1280dbs.jpg',
            Str::contains($name, ['razer']) => 'images/components/headset_speaker/headset_razer_blackshark_v2x.jpg',
            default => 'images/components/headset_speaker/headset_hyperx_cloud2.jpg',
        };
    }
}
