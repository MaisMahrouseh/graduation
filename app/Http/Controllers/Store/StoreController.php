<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\UserStore;
use App\Models\StoreDepartment;
use App\Models\StoreProduct;
use App\Models\Product;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\StoreProductRequest;
use App\Http\Requests\Store\SortLocationRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public $store;
    public $userStore;
    public $storeDepartment;
    public $storeProduct;

    public function __construct(Store $store,UserStore $userStore ,StoreDepartment $storeDepartment ,StoreProduct $storeProduct)
    {
        $this->store = $store;
        $this->userStore = $userStore;
        $this->storeDepartment = $storeDepartment;
        $this->storeProduct = $storeProduct;
    }

    //add store by user
    public function addStore(AddStoreRequest $request){
        $request->validated();
        $created = $this->store->addStore($request);
        if (!$created)
            return ResponseHelper::creatingFail();
        return ResponseHelper::operationSuccess($data = "تم بناء المتجر بنجاح, الرجاء الانتظار ليتم القبول او الرفض");
    }

    //allow to add store by admin
    public function allowAddStore($id){
        if (!$this->store->find($id))
          return ResponseHelper::DataNotFound($message = 'خطأ في معرّف المتجر');
        $update = $this->store->where('id',$id)->update([
            'allow' => 1,
        ]);;
        if (!$update)
            return ResponseHelper::operationFail();
        return ResponseHelper::operationSuccess();
    }

    //disallow to add store by admin
    public function disallowAddStore($id){
        if (!$this->store->find($id))
          return ResponseHelper::DataNotFound($message = 'خطأ في معرّف المتجر');
        $update = $this->store->where('id',$id)->update([
            'allow' => 0,
        ]);;
        if (!$update)
            return ResponseHelper::operationFail();
        return ResponseHelper::operationSuccess();
    }

    //get existing stores for admin
    public function existingStores(){
        $stores =  $this->userStore->getExistingStores()->whereNull('delet_date');
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //get deleted stores for admin
    public function deletedStores(){
        $stores =  $this->userStore->getExistingStores()->whereNotNull('delet_date');
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //recovery deleted store
    public function recoveryStore($id){
      $update = $this->store->where('id', $id)->withTrashed()->restore();
      if (!$update)
          return ResponseHelper::operationFail();
      return ResponseHelper::operationSuccess();
    }
    public function deleteStore($id){
        $storeId =  $this->store->find($id);
        if (!$storeId)
          return ResponseHelper::DataNotFound($message = 'خطأ في معرّف المتجر');
        $deleted = $storeId->delete();
        if (!$deleted)
           return ResponseHelper::deletingFail();
         return ResponseHelper::delete();
    }

    //get user stores
    public function myStores(){
        $stores = $this->userStore->getMyStores();
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //get details the store  and its departments and the remaining departments
    public function detailsStore($id){
        $details = $this->store->getDetails($id);
        if(!$details)
          return ResponseHelper::serverError();
        return ResponseHelper::select($details);
    }

    //Edit store details by owner
    public function editDetailsStore(AddStoreRequest $request,$id){
        $userStoreId =  $this->userStore->select('user_id')->where('store_id',$id)->get();
        if(auth()->user()->id != $userStoreId->first()->user_id)
           return ResponseHelper::operationFail($message = "انت لست مالك لهذا المتجر");
        $request->validated();
        $store = $this->store->find($id);
        if (!$store)
            return ResponseHelper::DataNotFound();
        $picture = $request->file('logo');
        if($request->hasFile('logo')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/StoreImages'),$picturename);
            $picturename = 'https://mais-api.preneom.com/public/images/StoreImages/'.(string)$picturename;
            $updated = $this->store->where('id',$id)->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'locationX' => $request->locationX,
                'locationY' => $request->locationY,
                'logo' => $picturename,
            ]);}
        if(!$updated)
            return ResponseHelper::updatingFail();
        return ResponseHelper::update($updated);
    }

    //Adding a product to the store with its details - its section - the chosen unite - with the possibility of adding a discount
    public function addStoreProduct(StoreProductRequest  $request){
        $request->validated();
        $created = $this->storeProduct->addStoreProduct($request);
        if (!$created)
            return ResponseHelper::creatingFail();
        return ResponseHelper::operationSuccess();
    }

    //get all stores
    public function getAllStores(){
        $stores = $this->store->getStores();
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //get store information
    public function getStore($id){
        $stores = $this->store->storeInfo($id);
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //Sorting stores according to the nearest store, starting from a specific point
    public function sortStoresLocation(SortLocationRequest $request){
        $request->validated();
        $stores = $this->store->getSortStoresLocation($request);
        if(!$stores)
          return ResponseHelper::serverError();
        return ResponseHelper::select($stores);
    }

    //Sort stores by alphabet
    public function sortStoresName(){
        $stores = $this->store->select('id', 'name', 'logo','locationX','locationY')
        ->where('allow',1)
        ->orderBy('name')
        ->get();

        $storesss =  collect($stores)->each(function ($store) {
        $store['rate'] = collect($store['rates'])->avg('rate');
        unset($store['rates']);
       });
        if(!$storesss)
          return ResponseHelper::serverError();
        return ResponseHelper::select($storesss);
    }

    //Sort stores according to the highest rating
    public function sortStoresRate(){
        $stores = $this->store->select('id', 'name', 'logo','locationX','locationY')
        ->where('allow',1)

        ->get();

        $storesss =  collect($stores)->each(function ($store) {
        $store['rate'] = collect($store['rates'])->avg('rate')->orderBy('rate','desc');
        unset($store['rates']);
       });
        if(!$storesss)
          return ResponseHelper::serverError();
        return ResponseHelper::select($storesss);
    }

    //Get لeneral stores containing this product
    public function generalProductStores($id){
      $selectId = Product::find($id);
      if (!$selectId)
          return ResponseHelper::DataNotFound($message = "معرّف المنتج غير محقق");
      $products = $this->storeProduct->generalStores($id);
      if(!$products)
        return ResponseHelper::serverError();
      return ResponseHelper::select($products);
    }

}
