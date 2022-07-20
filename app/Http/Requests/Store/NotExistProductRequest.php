<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class NotExistProductRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'text' => ['required', 'string'],
            'image' =>['required' , 'image'],
            'barcode' =>['nullable' , 'string'],
        ];
    }
    public function messages()
    {
       return [
        'text.required' => 'الاسم مطلوب',
        'text.string' => 'يجب ان يكون الاسم سلسلة نصية',
        'image.required' => 'الصورة مطلوبة',
        'image.image' => 'يجب ان يكون الحقل من نوع صورة',
        'barcode.string' => 'يجب ان يكون الباركود سلسلة نصية',
       ];
    }
}
