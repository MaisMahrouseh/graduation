<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\UserStore;
use App\Models\StoreDepartment;
use App\Http\Requests\Store\AddStoreRequest;
use App\Http\Requests\Store\AllowAddStoreRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;

class StoreController extends Controller
{
    public $store;
    public $userStore;
    public $storeDepartment;

    public function __construct(Store $store,UserStore $userStore ,StoreDepartment $storeDepartment)
    {
        $this->store = $store;
        $this->userStore = $userStore;
        $this->storeDepartment = $storeDepartment;
    }

    //add store by user
    public function addStore(AddStoreRequest $request){
        $request->validated();
        $created = $this->store->addStore($request);
        if (!$created)
            return ResponseHelper::creatingFail();
        return ResponseHelper::operationFail($message = "Operation completed successfully, please wait for permission");
    }

    //allow to add store by admin
    public function allowAddStore(AllowAddStoreRequest $request){
        $request->validated();
        $created = $this->store->allowAddStore($request);
        if (!$created)
            return ResponseHelper::operationFail();
        return ResponseHelper::operationSuccess();
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
           return ResponseHelper::operationFail($message = "You are not the owner of this store");
        $validated = $request->validated();
        $store = $this->store->find($id);
        if (!$store)
            return ResponseHelper::DataNotFound();
        $updated = $this->store->where('id',$id)->update($validated);
        if(!$updated)
            return ResponseHelper::updatingFail();
        return ResponseHelper::update($updated);
    }
}
