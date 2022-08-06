<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AddStoreDepartmentseRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'department_id' =>'required|integer|exists:stores,id',
            'store_id' => 'required|integer|exists:stores,id',
        ];
    }
    public function messages()
    {
       return [
        'store_id.required' => 'معرّف المتجر مطلوب',
        'store_id.exists' => 'معرّف المتجر هذا غير موجود',
        'department_id.required' => 'معرّف القسم مطلوب',
        'department_id.exists' => 'معرّف القسم هذا غير موجود',
       ];
    }
}
