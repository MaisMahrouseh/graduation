<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AddStoreRequest extends FormRequest
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
            'logo' =>['required' , 'image'],
            'phone' => ['required', 'string'],
            'locationX' =>['required', 'numeric'],
            'locationY' =>['required', 'numeric'],
        ];
    }
}
