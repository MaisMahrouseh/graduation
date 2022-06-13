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
}
