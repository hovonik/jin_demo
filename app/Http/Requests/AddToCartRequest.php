<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => [
                'required',
                Rule::exists('products', 'id')
            ],
            'count' => 'required|integer',
            'is_primary' => 'required|integer',
            'services' => [
                'array',
                'nullable',
            ],
            'services.*' => [
                Rule::exists('services', 'id')
            ],
            'shopping_cart_id' => 'nullable|integer'
        ];
    }
}
