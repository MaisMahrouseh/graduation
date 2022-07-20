<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'store_id' => ['required', 'integer', Rule::exists('stores', 'id')->whereNull('deleted_at')],
            'rate'=>['required','numeric','min:0','max:5'],
        ];
    }
    public function messages()
    {
       return [
        'store_id.required' => 'معرّف المتجر مطلوب',
        'store_id.exists' => 'معرّف المتجر هذا غير موجود',
        'rate.required' => 'حقل التقييم مطلوب',
        'rate.numeric' => 'يجب ان يكون التقيم رقم بين 0 و 5',
       ];
    }
}
