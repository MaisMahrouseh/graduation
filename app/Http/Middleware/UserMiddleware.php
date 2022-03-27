<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
   
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if ($user->is_admin  == 0){
         return $next($request);
        }

        return response()->json([
           'success' => false,
           'error' => 'you are not User!'
       ], 401);
    }
}
