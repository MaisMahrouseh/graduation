<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use App\Http\Requests\User\RegisterRequet;
use App\Http\Requests\User\LoginRequet;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function register(RegisterRequet $request){
        $validated = $request->validated();
        $created =  $this->user->createData($validated);
        $created['token'] = $created->createToken('wafer')->accessToken;
        if(!$created)
          return ResponseHelper::creatingFail();
         return ResponseHelper::create($created);
    }

    public function login(LoginRequet $request){
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $user['token'] = $user->createToken('wafer')->accessToken;
            return ResponseHelper::select($user);
        } else
            return ResponseHelper::authenticationFail();
    }

    public function logout(Request $request){
        try {
            $request->user()->token()->revoke();
            return ResponseHelper::operationSuccess();
        } catch (Exception $e) {
            return ResponseHelper::operationFail();
        }
    }
    
}
