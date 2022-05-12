<?php

namespace App\Http\Requests\User;

use Kouja\ProjectAssistant\Bases\BaseFormRequest;
use Kouja\ProjectAssistant\Rules\Phone;

class RegisterRequet extends BaseFormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' =>['nullable','email','unique:users'],
            'password' =>['required','min:6'],
            'phone' => ['nullable', 'string'],
        ];
    }
}
