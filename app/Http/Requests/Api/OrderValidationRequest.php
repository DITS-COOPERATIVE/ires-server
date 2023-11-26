<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderValidationRequest extends FormRequest
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
            'customer_id' => 'sometimes|exists:customers,id',
            'total' => 'required',
            'internal_note' => 'sometimes|string',
            "customer_note" => 'sometimes|string',
            'discount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.price' => 'required',
            'products.*.qty' => 'required',
            'products.*.points' => 'required',
            'products.*.sub_total' => 'required',
            'products.*.discount' => 'required',
        ];
    }
}
