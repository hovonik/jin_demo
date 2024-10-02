<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MasterRegistrationRequest extends FormRequest
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
            'profession_ids' => 'required|array',
            'profession_ids.*' => 'required|exists:professions,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:masters',
            'phone' => 'required|string|unique:masters',
            'password' => 'required|string',
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
