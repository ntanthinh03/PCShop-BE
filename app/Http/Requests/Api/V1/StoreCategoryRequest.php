<?php

namespace App\Http\Requests\Api\V1;

use App\Traits\HasValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    use HasValidationRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->categoryRules(isUpdate: false);
    }
}
