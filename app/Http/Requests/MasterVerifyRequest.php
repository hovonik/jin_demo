<?php

namespace App\Http\Requests;

use App\Constants\Parameters;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MasterVerifyRequest extends FormRequest
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
            'passport' => 'required|string',
            'driver_license' => 'nullable|'.Rule::requiredIf(function (){
                    return $this->user('masters')->isCourierOrDriver();
                }),
            'car_texpassport_number' => 'nullable|'.Rule::requiredIf(function (){
                    return $this->user('masters')->isCourierOrDriver();
                }),
            'car_texpassport_images' => 'nullable|'.Rule::requiredIf(function (){
                    return $this->user('masters')->isCourierOrDriver();
                }),
            'passport_images' => 'required|array',
            'driver_license_images' => 'nullable|array|'.Rule::requiredIf(function (){
                    return $this->user('masters')->isCourierOrDriver();
                }),
            'car_images' => 'nullable|array|'.Rule::requiredIf(function (){
                    return $this->user('masters')->isCourierOrDriver();
                })
        ];
    }
}
