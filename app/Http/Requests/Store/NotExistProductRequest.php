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
        ];
    }
}
