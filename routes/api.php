<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api' , 'isAdmin'])->group(function () {

});


Route::middleware(['auth:api' , 'isUser'])->group(function () {
   
});