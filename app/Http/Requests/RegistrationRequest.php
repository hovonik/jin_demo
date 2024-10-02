<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|string|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string',
            'address' => 'nullable|string',
            'town' => 'nullable|string',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'avatar' => 'nullable|string',
            'birthday' => 'nullable|date_format:Y-m-d',
            'lang' => 'required|string|in:en,ru,hy'
        ];
    }
}
