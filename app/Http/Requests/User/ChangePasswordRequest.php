<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'oldPassword' => ['required','string'],
            'newPassword' => ['required','string','min:6'],
            'confirmPassword' => ['required','same:newPassword','min:6'],
        ];
    }
}
