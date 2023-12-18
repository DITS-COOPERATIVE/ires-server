<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'string|max:191',
            'model'         => 'string|max:191',
            'price'         => ['regex:/^\d+(\.\d{1,2})?$/'], 
            'quantity'      => 'numeric',
            'points'        => 'numeric',
            'image'         => 'file|image',
            'category'      => 'string',
            'subProducts'   => 'nullable|array',
            'subProducts.*.id' => 'exists:products,id',
            'subProducts.*.qty' => 'integer|min:1',
        ];
    }
}
