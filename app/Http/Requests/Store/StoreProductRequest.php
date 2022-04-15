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
}
