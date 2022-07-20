<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'image' =>['required' , 'image'],
            'product_id' =>'nullable|exists:products,id',
        ];

    }
    public function messages()
    {
       return [
        'name.required' => 'الاسم مطلوب',
        'name.string' => 'يجب ان يكون الاسم سلسلة نصية',
        'image.required' => 'الصورة مطلوبة',
        'image.image' => 'يجب ان يكون الحقل من نوع صورة',
        'product_id.exists' => 'Not an existing ID',
       ];
    }
}
