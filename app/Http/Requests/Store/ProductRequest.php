<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'barcode'=>['required', 'string',Rule::unique('products')->ignore($this->product)->whereNull('deleted_at')],
        ];

    }
    public function messages()
    {
       return [
        'name.required' => 'الاسم مطلوب',
        'name.string' => 'يجب ان يكون الاسم سلسلة نصية',
        'image.required' => 'الصورة مطلوبة',
        'image.image' => 'يجب ان يكون الحقل من نوع صورة',
        'product_id.exists' => 'معرّف المنتج هذا غير موجود',
        'barcode.required' => 'الباركود مطلوب',
        'barcode.string' => 'يجب ان يكون الباركود سلسلة نصية',
        'barcode.unique' => 'هذا المنتج موجود من قبل',

       ];
    }
}
