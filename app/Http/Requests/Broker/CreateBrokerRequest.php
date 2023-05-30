<?php

namespace App\Http\Requests\Broker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateBrokerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'photo' => 'required|mimes:jpeg,jpg,png'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required as per Aadhaar',
            'photo.required' => 'A photo is required as per Aadhaar',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
