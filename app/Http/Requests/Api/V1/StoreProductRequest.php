<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'specs' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'string|url',
        ];
    }
}
