<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class SortLocationRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'locationX' =>['required', 'numeric'],
            'locationY' =>['required', 'numeric'],
        ];

    }
    public function messages()
    {
       return [
        'locationX.required' => 'الاحداثيات مطلوبة',
        'locationX.numeric' => 'يجب ان تكون الاحداثيات عدد بفاصلة',
        'locationY.required' => 'الاحداثيات مطلوبة',
        'locationY.numeric' => 'يجب ان تكون الاحداثيات عدد بفاصلة',
       ];
    }
}
