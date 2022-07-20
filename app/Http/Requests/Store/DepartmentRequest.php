<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' =>['required','string', Rule::unique('departments')->ignore($this->department)->whereNull('deleted_at')]
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
