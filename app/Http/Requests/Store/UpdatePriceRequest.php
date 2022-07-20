<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
class UpdatePriceRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'store_id' =>'required|exists:stores,id',
            'percent' => 'required|integer|between:0,100'
        ];
    }
    public function messages()
    {
       return [
        'store_id.required' => 'معرف المتجر مطلوب',
        'store_id.exists' => 'معرّف المتجر هذا غير موجود',
        'percent.required' => 'النسبة مطلوبة',
        'percent.integer' => 'يجب ان تكون النسبة عدد صحيح بين 0 و 100',

       ];
    }
}
