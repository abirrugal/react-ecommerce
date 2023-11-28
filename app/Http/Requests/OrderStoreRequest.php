<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderStoreRequest extends FormRequest
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
            'phone' => 'required|numeric|digits_between:1,15',
            'email' => 'nullable|email',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'delivery_place' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator){
        validationError($validator);
    }
}
