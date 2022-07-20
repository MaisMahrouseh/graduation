<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequet extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email' =>['nullable','email'],
            'password' =>['required'],
        ];
    }
    public function messages()
    {
       return [
        'email.email' => 'يجب ان يكون الحقل من نوع ايميل',
        'password.required' => 'كلمة المرور مطلوبة',
       ];
    }
}
