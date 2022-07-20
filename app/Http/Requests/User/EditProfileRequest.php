<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProfileRequest extends FormRequest
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
            'email' =>['required', Rule::unique('users','email')->ignore(auth()->user()->id)],
            'phone' => ['required', 'string'],
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
        'phone.required' => 'رقم الموبايل  مطلوب',
       ];
    }
}
