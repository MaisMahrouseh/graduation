<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AddStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'logo' =>['required' , 'image'],
            'phone' => ['required', 'string'],
            'locationX' =>['required', 'numeric'],
            'locationY' =>['required', 'numeric'],
        ];

    }
    public function messages()
    {
       return [
        'name.required' => 'الاسم مطلوب',
        'name.string' => 'يجب ان يكون الاسم سلسلة نصية',
        'logo.required' => 'الصورة مطلوبة',
        'logo.image' => 'يجب ان يكون الحقل من نوع صورة',
        'phone.required' => 'الرقم مطلوب',
        'locationX.required' => 'الاحداثيات مطلوبة',
        'locationX.numeric' => 'يجب ان تكون الاحداثيات عدد بفاصلة',
        'locationY.required' => 'الاحداثيات مطلوبة',
        'locationY.numeric' => 'يجب ان تكون الاحداثيات عدد بفاصلة',
       ];
    }
}
