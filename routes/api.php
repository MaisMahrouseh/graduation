<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Store\UniteController;
use App\Http\Controllers\Store\DepartmentController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\Store\SoldController;
use App\Http\Controllers\User\CartController;


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
    Route::Get('alldepartment', [DepartmentController::class, 'index']);// NO
    Route::post('adddepartment', [DepartmentController::class, 'store']);// NO
    Route::post('addstore', [StoreController::class, 'addStore']);//notification no
    Route::Get('mystores', [StoreController::class, 'myStores']);// NO
    Route::Get('detailsstore/{id?}', [StoreController::class, 'detailsStore']);// NO
    Route::Get('addstoredepartment', [DepartmentController::class, 'addStoreDepartments']);// NO
    Route::Delete('deletestoredepartment/{id?}', [DepartmentController::class, 'deleteStoreDepartments']);// NO
    Route::post('editdetailsstore/{id?}', [StoreController::class, 'editDetailsStore']);// NO
    Route::post('search', [ProductController::class, 'search']);/**/ // NO
    Route::Get('allUnite', [UniteController::class, 'index']);// NO
    Route::Get('mydepartmentstore/{id?}', [DepartmentController::class, 'myDepartmentStore']);// NO
    Route::post('addstoreproduct', [StoreController::class, 'addStoreProduct']);// NO
    Route::post('notexistproduct', [ProductController::class, 'notExistProduct']);//notification no
    Route::get('mystoreproducts/{id?}', [ProductController::class, 'myStoreProducts']);// NO
    Route::get('Deletemystoreproducts/{id?}', [ProductController::class, 'deleteMyStoreProducts']);// NO
    //edit store product
    
    Route::get('allstores', [StoreController::class, 'getAllStores']);// NO
    Route::get('sortstorename', [StoreController::class, 'sortStoresName']);// NO
    Route::get('sortstorerate', [StoreController::class, 'sortStoresRate']);// NO
    Route::post('sortstorelocation', [StoreController::class, 'sortStoresLocation']);// NO
    Route::get('astore/{id?}', [StoreController::class, 'getStore']);// NO
    //Route::post('storedepartmentproducts', [ProductController::class, 'storeDepartmentProducts']); // NO
    Route::post('favorite', [ActivityController::class, 'favorite']);// NO
    Route::get('myfavorite', [ActivityController::class, 'myFavorite']);// NO
    Route::post('rate', [ActivityController::class, 'rate']);// NO
    Route::get('myrate', [ActivityController::class, 'myRate']);// NO
    Route::get('getProfile', [ActivityController::class, 'getMyProfile']);// NO
    Route::post('editProfile', [ActivityController::class, 'editMyProfile']);// NO
    Route::post('changepassword', [ActivityController::class, 'changePassword']);// NO
    //reset password
    Route::get('generaldepartmentproducts/{id?}', [DepartmentController::class, 'generalDepartmentProducts']);// NO
    Route::get('generalproductstores/{id?}', [StoreController::class, 'generalProductStores']);// NO
    Route::get('allsolds', [SoldController::class, 'allSolds']);// NO
    Route::post('storingsearchruser', [ActivityController::class, 'storingSearchUser']);// NO
    Route::get('Recentsearchresults', [ActivityController::class, 'recentSearchResults']);// NO
    Route::get('Mostsearched', [ActivityController::class, 'mostSearched']);// NO
    Route::post('addtocart/{id?}', [CartController::class, 'addTocart']);// NO
    Route::post('cheapestproduct/{id?}', [CartController::class, 'cheapestProduct']);// NO
    Route::post('closesttproduct/{id?}', [CartController::class, 'closestProduct']);// NO
    Route::get('getcart', [CartController::class, 'getCart']);// NO
    Route::Delete('removefromcart/{id?}', [CartController::class, 'removeFromCart']);// NO



    
});

Route::get('migrate', function(){
    Artisan::call("migrate:fresh --seed");
    Artisan::call("passport:install");
    Artisan::call("migrate --path=database/migrations/ForeignKeys");
});
