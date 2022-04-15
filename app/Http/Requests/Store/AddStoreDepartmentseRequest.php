<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AddStoreDepartmentseRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'departments' => ['required','array','min:1'],
            'departments.*' => ['required','integer'],
            'store_id' => ['required','integer'],
        ];
    }
}
