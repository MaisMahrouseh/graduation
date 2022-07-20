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
    public function messages()
    {
       return [
        'oldPassword.required' => 'كلمة المرور القديمة مطلوبة',
        'oldPassword.string' => 'كلمة المرور القديمة يجب ان تكون سلسلة نصية',
        'newPassword.required' => 'كلمة المرور الجديدة مطلوبة',
        'newPassword.string' => '  كلمة المرور الجديدة يجب ان تكون سلسلة نصية ومكونة من 6 محارف محد ادنى',
        'confirmPassword.required' => 'تأكيد كلمة المرور مطلوب',
        'confirmPassword.same' => 'تأكيد كلمة يجب ان تكون مطابقة لكلمة المرور الجديدة المدخلة',
        'confirmPassword.min' => ' تأكيد كلمة يجب ان تكون مطابقة لكلمة المرور الجديدة المدخلة ومكونة من 6 محارف كحد ادنى',
       ];
    }
}
