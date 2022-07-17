<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaticeYearRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'year' => 'required|date_format:Y|before:today',
        ];
    }
}
