<?php

namespace App\Traits;

use Illuminate\Validation\Rule;

trait HasValidationRules
{
    /**
     * Common category validation rules.
     */
    protected function categoryRules(bool $isUpdate = false, ?int $ignoreId = null): array
    {
        $prefix = $isUpdate ? 'sometimes|' : '';

        $slugRule = Rule::unique('categories', 'slug');
        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
        }

        return [
            'name' => $prefix.'required|string|max:255',
            'slug' => array_filter([$isUpdate ? 'sometimes' : null, 'required', 'string', 'max:255', $slugRule]),
            'description' => 'nullable|string',
        ];
    }

    /**
     * Common product validation rules.
     *
     * @param  array|null  $allowedFields  Fields to include in the returned rules array.
     */
    protected function productRules(bool $isUpdate = false, ?int $ignoreId = null, ?array $allowedFields = null): array
    {
        $prefix = $isUpdate ? 'sometimes|' : '';

        $slugRule = Rule::unique('products', 'slug');
        $skuRule = Rule::unique('products', 'sku');

        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
            $skuRule->ignore($ignoreId);
        }

        $allRules = [
            'category_id' => $prefix.'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'name' => $prefix.'required|string|max:255',
            'slug' => array_filter([$isUpdate ? 'sometimes' : null, 'required', 'string', 'max:255', $slugRule]),
            'sku' => array_filter([$isUpdate ? 'sometimes' : null, 'required', 'string', 'max:255', $skuRule]),
            'description' => 'nullable|string',
            'specs' => 'nullable|array',
            'price' => $prefix.'required|numeric|min:0',
            'stock_quantity' => $prefix.'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'string|url',
        ];

        if ($allowedFields !== null) {
            return array_intersect_key($allRules, array_flip($allowedFields));
        }

        return $allRules;
    }
}
