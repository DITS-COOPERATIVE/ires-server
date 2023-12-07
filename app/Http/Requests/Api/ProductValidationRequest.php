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
            'name'          => 'string|max: 191',
            'model'         => 'string|max: 191',
            'price'         => 'numeric',
            'quantity'      => 'numeric',
            'points'        => 'numeric',
            'image'         => 'string',
            'category'      => 'string',
        ];
    }
}
