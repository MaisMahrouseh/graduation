<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUnitRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' =>['required','string'],
            'id' =>['required']
        ];
    }
    public function messages()
    {
       return [
        'name.required' => 'الاسم مطلوب',
        'name.string' => 'يجب ان يكون الاسم سلسلة نصية',
       ];
    }
}
