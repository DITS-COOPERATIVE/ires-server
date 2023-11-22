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
            'name'          => 'required|string|max: 191',
            'code'          => 'required|string|max: 191',
            'model'         => 'required|string|max: 191',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
            'points'        => 'required|numeric',
            'image'         => 'string',
            'category'      => 'required',
        ];
    }
}
