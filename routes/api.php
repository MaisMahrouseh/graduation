<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Store\UniteController;
use App\Http\Controllers\Store\DepartmentController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api' , 'isAdmin'])->group(function () {
    Route::resource('unite', UniteController::class);
    Route::post('updateu/{id?}', [UniteController::class, 'updateU']);
    Route::resource('department', DepartmentController::class);
    Route::post('updated/{id?}', [DepartmentController::class, 'updateD']);


});


Route::middleware(['auth:api' , 'isUser'])->group(function () {
   
});