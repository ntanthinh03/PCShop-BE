<?php

namespace App\Http\Requests\Api\V1;

use App\Traits\HasValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    use HasValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return $this->categoryRules(isUpdate: true, ignoreId: $categoryId);
    }
}
