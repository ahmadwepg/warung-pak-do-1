<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'Nasi Goreng' => [
                'Biasa' => 11000,
                'Jawa' => 11000,
                'Mawut' => 12000,
                'Ati' => 13000,
                'Telur' => 14000,
                'Pete' => 14000,
                'Ayam' => 14000,
                'Spesial' => 18000,
            ],
            'Mie/Kwetiau/Bihun' => [
                'Bakmi Goreng' => 11000,
                'Bakmi Kuah' => 11000,
                'Bakmi Kuah Merah' => 12000,
                'Kwetiau Goreng' => 11000,
                'Kwetiau Kuah' => 11000,
                'Kwetiau Kuah Merah' => 12000,
                'Bihun Goreng' => 12000,
                'Bihun Kuah' => 12000,
            ],
            'Menu Ayam' => [
                'Ayam Geprek' => 9000,
                'Ayam Goreng' => 10500,
                'Ayam Saus' => 11000,
                'Nasi Ayam Geprek' => 11000,
                'Nasi Ayam Saus' => 12000,
                'Nasi Ayam Goreng' => 13000,
            ],
            'Capcay/Paklay' => [
                'Capcay Goreng' => 11000,
                'Capcay Kuah' => 11000,
                'Paklay' => 11000,
                'Capcay Kuah Merah' => 12000,
            ],
            'Lain-lain' => [
                'Telur Dadar' => 3000,
                'Telur Ceplok' => 3000,
                'Nasi Putih' => 3000,
                'Fuyunghai' => 11000,
                'Ca Brokoli' => 13000,
                'Sapo Tahu' => 14000,
                'Nasi Fuyunghai' => 14000,
            ],
            'Minuman' => [
                'Teh' => 3000,
                'Lemon Tea' => 3000,
                'Chocolatos/Milo' => 4000,
                'Jeruk' => 4000,
                'White Coffee' => 4000,
            ],
        ];

        $categoryColors = [
            'Nasi Goreng' => '#e8a838',
            'Mie/Kwetiau/Bihun' => '#d46b08',
            'Menu Ayam' => '#ff8c42',
            'Capcay/Paklay' => '#6ab04c',
            'Lain-lain' => '#a0522d',
            'Minuman' => '#2196f3',
        ];

        foreach ($catalog as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->firstOrFail();
            $slug = Str::slug($categoryName);
            $color = $categoryColors[$categoryName] ?? '#888888';
            $svgPath = "products/{$slug}.svg";

            // Generate SVG if not exists
            if (!Storage::disk('public')->exists($svgPath)) {
                $svg = $this->generateCategorySvg($categoryName, $color);
                Storage::disk('public')->put($svgPath, $svg);
            }

            foreach ($products as $productName => $price) {
                Product::updateOrCreate(
                    ['name' => $productName],
                    [
                        'category_id' => $category->id,
                        'description' => $productName . ' khas Warung Pak Do.',
                        'price' => $price,
                        'image' => $svgPath,
                        'stock' => 100,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function generateCategorySvg(string $name, string $color): string
    {
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" width="400" height="300">
  <rect width="400" height="300" fill="{$color}"/>
  <text x="200" y="150" font-family="Arial, sans-serif" font-size="36" fill="white" text-anchor="middle" dominant-baseline="middle">
    {$name}
  </text>
</svg>
SVG;
        return $svg;
    }
}