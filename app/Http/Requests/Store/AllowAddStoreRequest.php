<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class AllowAddStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'user_id' =>'required|exists:users,id',
            'store_id' =>'required|exists:stores,id',
        ];

     
    }
    public function messages()
    {
       return [
        'store_id.exists' => 'Not an existing ID',
        'user_id.exists' => 'Not an existing ID',
       ];
    }
  
    
}
