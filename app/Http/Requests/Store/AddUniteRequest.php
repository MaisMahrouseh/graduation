<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddUniteRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string' , Rule::unique('unites')],
        ];
    }
}
