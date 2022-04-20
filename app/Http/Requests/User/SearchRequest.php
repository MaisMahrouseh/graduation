<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
  
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'text' => ['required', 'string']
        ];
    }
    public function messages()
    {
       return [
        'text.required' => 'الرجاء ادخال نص البحث المطلوب',
       ];
    }
}
