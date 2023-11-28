<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'region' => ['required','string'],
            'address' =>  ['required', 'string'],
            'city' => ['required','string'],
            'area' => ['required','string'],
            'phone' => ['required','numeric'],
            'address_type' => ['required','numeric'],
        ];
    }

    public function failedValidation(Validator $validator){
        validationError($validator);
    }
}
