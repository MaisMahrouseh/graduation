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
    public function messages()
    {
       return [
        'firstname.required' => 'الاسم الاول مطلوب',
        'firstname.string' => 'يجب ان يكون الاسم الاول سلسلة نصية',
        'lastname.required' => 'الاسم الثاني مطلوب',
        'lastname.string' => 'يجب ان يكون الاسم الثاني سلسلة نصية',
        'email.required' => ' الايميل  مطلوب وفريد',
        'password.required' => ' كلمة المرور مطلوبة',
        'password.min' => 'كلمة المرور يجب ان تكون مكونة من 6 محارف كحد أدنى',


       ];
    }
}
