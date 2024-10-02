<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressInfoRequest extends FormRequest
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
            'order_id' => [
                'required',
                Rule::exists('shopping_carts', 'id')
            ],
            'address' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'cache_on_delivery' => 'nullable|integer'
        ];
    }
}
