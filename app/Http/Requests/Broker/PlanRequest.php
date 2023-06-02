<?php

namespace App\Http\Requests\Broker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'plan_name' => ['required',$this->id?Rule::unique('plans')->ignore($this->id):'unique:plans'],
            'plan_details' => 'required',
            'plan_price' => 'required',
            'plan_duration' => 'required',
            'is_plan_free_trial' => 'required',
            'broker_id' => 'required'
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
