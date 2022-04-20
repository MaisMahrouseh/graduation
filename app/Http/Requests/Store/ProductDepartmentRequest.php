<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class ProductDepartmentRequest extends FormRequest
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
            'department_id' =>'required|exists:departments,id',
        ];
    }
    public function messages()
    {
       return [
        'store_id.exists' => 'Not an existing store ID',
        'department_id.exists' => 'Not an existing department ID',
       ];
    }
}
