<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $rawImages = $this->images;
        if (is_string($rawImages)) {
            $decoded = json_decode($rawImages, true);
            $rawImages = is_array($decoded) ? $decoded : [$rawImages];
        }
        if (! is_array($rawImages)) {
            $rawImages = [];
        }

        $formattedImages = array_values(array_filter(array_map(function ($img) {
            if (empty($img)) {
                return null;
            }
            if (str_starts_with($img, 'http://') || str_starts_with($img, 'https://')) {
                return $img;
            }

            return asset(ltrim($img, '/'));
        }, $rawImages)));

        if (empty($formattedImages)) {
            $formattedImages = ['https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=400'];
        }

        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'category_id' => $this->category_id,
            'category_name' => $this->whenLoaded('category', fn () => $this->category->name),
            'category_slug' => $this->whenLoaded('category', fn () => $this->category->slug),
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'description' => $this->description,
            'specs' => $this->specs ?? (object) [],
            'price' => (float) $this->price,
            'stock_quantity' => $this->stock_quantity,
            'images' => $formattedImages,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
