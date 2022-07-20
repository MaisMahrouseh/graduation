<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_id' =>'required|exists:products,id',
            'department_id' =>'required|exists:departments,id',
            'unite_id' =>'required|exists:unites,id',
            'price' => ['required','numeric','between:0,9999999'],
            'batch_number'=> ['required','string'],
            'describe' => ['required','string'],
            'start_date' => 'nullable|date|after:yesterday',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'new_price' => ['nullable','numeric','between:0,9999999'],
        ];
    }
    public function messages()
    {
       return [
        'store_id.required' => 'معرّف المتجر مطلوب',
        'store_id.exists' => 'معرّف المتجر هذا غير موجود',
        'product_id.required' => 'معرّف المنتج مطلوب',
        'product_id.exists' => 'معرّف المنتج هذا غير موجود',
        'department_id.required' => 'معرّف القسم مطلوب',
        'department_id.exists' => 'معرّف القسم هذا غير موجود',
        'unite_id.required' => 'معرّف الواحدة مطلوب',
        'unite_id.exists' => 'معرّف الواحدة هذه غير موجود',
        'price.required' => 'السعر  مطلوب',
        'price.numeric' => 'يجب ان يكون السعر رقم بين 0 و 9999999',
        'batch_number.required' => 'رقم الدفعة مطلوب',
        'batch_number.string' => 'يجب ان يكون رقم الدفعة سلسلة نصية',
        'describe.required' => 'الوصف  مطلوب',
        'describe.string' => 'يجب ان يكون الوصف  سلسلة نصية',
        'start_date.date' => 'يجب ان يكون النوع تاريخ وبعد تاريخ اليوم الحالي',
        'end_date.string' => 'يجب ان يكون النوع تاريخ وبعد او يساوي تاريخ البداية',
        'new_price.numeric' => 'يجب ان يكون السعر رقم بين 0 و 9999999',
       ];
    }
}
