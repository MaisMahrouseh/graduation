<?php

namespace App\Http\Requests\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
       return [
        'store_id.exists' => 'Not an existing store ID',
       ];
    }
}
