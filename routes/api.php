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

//Route::middleware(['auth:api' , 'cors'])->group(function () {
    Route::resource('unite', UniteController::class);
    Route::post('deleteunite/{id}', [UniteController::class, 'deleteUnite']);
    Route::post('updateu/{id}', [UniteController::class, 'updateU']);
    Route::resource('department', DepartmentController::class);
    Route::post('deletedepartment/{id}', [DepartmentController::class, 'deeleteDepartment']);
    Route::post('updated/{id}', [DepartmentController::class, 'updateD']);
    Route::resource('product', ProductController::class);
    Route::post('updatep/{id}', [ProductController::class, 'updateP']);
    Route::get('existingstores', [StoreController::class, 'existingStores']);
    Route::get('deletedstores', [StoreController::class, 'deletedStores']);
    Route::post('allowaddstore/{id}', [StoreController::class, 'allowAddStore']);//notification
    Route::post('disallowaddstore/{id}', [StoreController::class, 'disallowAddStore']);//notification
    Route::post('recoverystore/{id}', [StoreController::class, 'recoveryStore']);
    Route::Delete('deletestore/{id}', [StoreController::class, 'deleteStore']);
//});


Route::middleware(['auth:api' , 'isUser'])->group(function () {
    Route::post('adddepartment', [DepartmentController::class, 'store']);
    Route::post('addstore', [StoreController::class, 'addStore']);//notification
    Route::Get('mystores', [StoreController::class, 'myStores']);
    Route::Get('detailsstore/{id}', [StoreController::class, 'detailsStore']);
    Route::post('addstoredepartment', [DepartmentController::class, 'addStoreDepartments']);
    Route::Delete('deletestoredepartment/{id}', [DepartmentController::class, 'deleteStoreDepartments']);
    Route::post('editdetailsstore/{id?}', [StoreController::class, 'editDetailsStore']);
    Route::post('search', [ProductController::class, 'search']);
    Route::Get('allUnite', [UniteController::class, 'index']);
    Route::Get('mydepartmentstore/{id}', [DepartmentController::class, 'myDepartmentStore']);
    Route::post('addstoreproduct', [StoreController::class, 'addStoreProduct']);
    Route::post('notexistproduct', [ProductController::class, 'notExistProduct']);//notification
    Route::get('mystoreproducts/{id}', [ProductController::class, 'myStoreProducts']);
    Route::get('Deletemystoreproducts/{id}', [ProductController::class, 'deleteMyStoreProducts']);
    Route::post('editallprices', [ProductController::class, 'editAllPrices']);

    //edit store product
    //add update delete solds store

    Route::get('allstores', [StoreController::class, 'getAllStores']);
    Route::get('sortstorename', [StoreController::class, 'sortStoresName']);
    Route::get('sortstorerate', [StoreController::class, 'sortStoresRate']);
    Route::post('sortstorelocation', [StoreController::class, 'sortStoresLocation']);
    Route::get('astore/{id}', [StoreController::class, 'getStore']);
    //Route::post('storedepartmentproducts', [ProductController::class, 'storeDepartmentProducts']); // NO

    Route::post('favorite', [ActivityController::class, 'favorite']);
    Route::get('myfavorite', [ActivityController::class, 'myFavorite']);
    Route::post('rate', [ActivityController::class, 'rate']);
    Route::get('myrate', [ActivityController::class, 'myRate']);
    Route::get('getProfile', [ActivityController::class, 'getMyProfile']);
    Route::post('editProfile', [ActivityController::class, 'editMyProfile']);
    Route::post('changepassword', [ActivityController::class, 'changePassword']);
    //reset password

    Route::Get('alldepartment', [DepartmentController::class, 'index']);
    Route::get('generaldepartmentproducts/{id}', [DepartmentController::class, 'generalDepartmentProducts']);
    Route::get('generalproductstores/{id}', [StoreController::class, 'generalProductStores']);
    Route::get('allsolds', [SoldController::class, 'allSolds']);

    Route::post('storingsearchruser', [ActivityController::class, 'storingSearchUser']);
    Route::get('Recentsearchresults', [ActivityController::class, 'recentSearchResults']);
    Route::get('Mostsearched', [ActivityController::class, 'mostSearched']);
    Route::post('addtocart/{id}', [CartController::class, 'addTocart']);
    Route::post('cheapestproduct/{id}', [CartController::class, 'cheapestProduct']);
    Route::post('closesttproduct/{id}', [CartController::class, 'closestProduct']);

    Route::get('getcart', [CartController::class, 'getCart']);
    Route::Delete('removefromcart/{id}', [CartController::class, 'removeFromCart']);
    Route::post('cheapestcart', [CartController::class, 'cheapestCart']);

    //nearest cart - cheapest cart- .....

});

Route::get('migrate', function(){
    Artisan::call("migrate:fresh --seed");
    Artisan::call("passport:install");
    Artisan::call("migrate --path=database/migrations/ForeignKeys");
});
