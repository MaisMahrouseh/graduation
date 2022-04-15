<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Store\UniteController;
use App\Http\Controllers\Store\DepartmentController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\User\ActivityController;


Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware(['auth:api' , 'isAdmin'])->group(function () {
    Route::resource('unite', UniteController::class);
    Route::post('updateu/{id?}', [UniteController::class, 'updateU']);
    Route::resource('department', DepartmentController::class);
    Route::post('updated/{id?}', [DepartmentController::class, 'updateD']);
    Route::resource('product', ProductController::class);
    Route::post('updatep/{id?}', [ProductController::class, 'updateP']);
    Route::post('allowaddstore', [StoreController::class, 'allowAddStore']);//notification


});


Route::middleware(['auth:api' , 'isUser'])->group(function () {
    Route::Get('alldepartment', [DepartmentController::class, 'index']);
    Route::post('adddepartment', [DepartmentController::class, 'store']);
    Route::post('addstore', [StoreController::class, 'addStore']);//notification
    Route::Get('mystores', [StoreController::class, 'myStores']);
    Route::Get('detailsstore/{id?}', [StoreController::class, 'detailsStore']);
    Route::Get('addstoredepartment', [DepartmentController::class, 'addStoreDepartments']);
    Route::Delete('deletestoredepartment/{id?}', [DepartmentController::class, 'deleteStoreDepartments']);
    Route::post('editdetailsstore/{id?}', [StoreController::class, 'editDetailsStore']);

    Route::Get('allUnite', [UniteController::class, 'index']);
    Route::Get('mydepartmentstore/{id?}', [DepartmentController::class, 'myDepartmentStore']);
    Route::post('addstoreproduct', [StoreController::class, 'addStoreProduct']);
    Route::post('notexistproduct', [ProductController::class, 'notExistProduct']);//notification


    Route::get('allstores', [StoreController::class, 'getAllStores']);
    Route::get('astore/{id?}', [StoreController::class, 'getStore']);
    Route::get('getstoredepartmentproducts', [DepartmentController::class, 'storeDepartmentProducts']);


    Route::post('favorite', [ActivityController::class, 'favorite']);
    Route::get('myfavorite', [ActivityController::class, 'myFavorite']);
    Route::post('rate', [ActivityController::class, 'rate']);
    Route::get('myrate', [ActivityController::class, 'myRate']);
    Route::get('getProfile', [ActivityController::class, 'getMyProfile']);
    Route::post('editProfile', [ActivityController::class, 'editMyProfile']);
    Route::post('changepassword', [ActivityController::class, 'changePassword']);



});