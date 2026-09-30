<?php

namespace App\Http\Requests\Api\V1;

use App\Traits\HasValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    use HasValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        $allowedFields = [
            'category_id',
            'name',
            'slug',
            'sku',
            'description',
            'price',
            'stock_quantity',
            'images',
            'images.*',
        ];

        return $this->productRules(isUpdate: true, ignoreId: $productId, allowedFields: $allowedFields);
    }
}
