<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAccountRequest extends FormRequest
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
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable|string',
            'town' => 'nullable|string',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'avatar' => 'nullable|string',
            'birthday' => 'nullable|date_format:Y-m-d',
            'lang' => 'nullable|string|in:en,ru,hy'
        ];
    }
}
