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
    Route::get('existingstores', [StoreController::class, 'existingStores']);//NO
    Route::get('deletedstores', [StoreController::class, 'deletedStores']);//NO
    Route::post('allowaddstore/{id?}', [StoreController::class, 'allowAddStore']);//notification and NO
    Route::post('disallowaddstore/{id?}', [StoreController::class, 'disallowAddStore']);//notification and NO
    Route::post('recoverystore/{id?}', [StoreController::class, 'recoveryStore']);// NO
    Route::Delete('deletestore/{id?}', [StoreController::class, 'deleteStore']);// NO
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
    Route::post('search', [ProductController::class, 'search']);/**/ 
    Route::Get('allUnite', [UniteController::class, 'index']);
    Route::Get('mydepartmentstore/{id?}', [DepartmentController::class, 'myDepartmentStore']);
    Route::post('addstoreproduct', [StoreController::class, 'addStoreProduct']);
    Route::post('notexistproduct', [ProductController::class, 'notExistProduct']);//notification
    Route::get('mystoreproducts/{id?}', [ProductController::class, 'myStoreProducts']);
    //edit store product
    
    Route::get('allstores', [StoreController::class, 'getAllStores']);
    Route::get('sortstorename', [StoreController::class, 'sortStoresName']);
    Route::get('sortstorerate', [StoreController::class, 'sortStoresRate']);
    Route::post('sortstorelocation', [StoreController::class, 'sortStoresLocation']);
    Route::get('astore/{id?}', [StoreController::class, 'getStore']);
    //Route::post('storedepartmentproducts', [ProductController::class, 'storeDepartmentProducts']);
    Route::post('favorite', [ActivityController::class, 'favorite']);
    Route::get('myfavorite', [ActivityController::class, 'myFavorite']);
    Route::post('rate', [ActivityController::class, 'rate']);
    Route::get('myrate', [ActivityController::class, 'myRate']);
    Route::get('getProfile', [ActivityController::class, 'getMyProfile']);
    Route::post('editProfile', [ActivityController::class, 'editMyProfile']);
    Route::post('changepassword', [ActivityController::class, 'changePassword']);
    //reset password
    Route::post('storingsearchruser', [ActivityController::class, 'storingSearchUser']);
    Route::get('Recentsearchresults', [ActivityController::class, 'recentSearchResults']);
    Route::get('Mostsearched', [ActivityController::class, 'mostSearched']);
    Route::get('generaldepartmentproducts/{id?}', [DepartmentController::class, 'generalDepartmentProducts']);
    Route::get('generalproductstores/{id?}', [StoreController::class, 'generalProductStores']);


    
});

Route::get('migrate', function(){
    Artisan::call("migrate:fresh --seed");
    Artisan::call("passport:install");
    Artisan::call("migrate --path=database/migrations/ForeignKeys");
});
