<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'store_id' => ['required', 'integer', Rule::exists('stores', 'id')->whereNull('deleted_at')],
            'rate'=>['required','numeric','min:0','max:5'],
        ];
    }
    public function messages()
    {
       return [
        'store_id.exists' => 'Not an existing store ID',
       ];
    }
}
