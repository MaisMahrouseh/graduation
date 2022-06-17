<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StoreDepartment;
use App\Models\StoreProduct;
use App\Http\Requests\Store\DepartmentRequest;
use App\Http\Requests\Store\AddStoreDepartmentseRequest;
use App\Http\Requests\Store\ProductDepartmentRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;

class DepartmentController extends Controller
{
    public $department;
    public $storeDepartment;
    public $storeProduct;
    public function __construct(Department $department , StoreDepartment $storeDepartment, StoreProduct $storeProduct)
    {
        $this->department = $department;
        $this->storeDepartment = $storeDepartment;
        $this->storeProduct = $storeProduct;
    }

    //show all departments
    public function index()
    {
        $departments = $this->department->orderBy('id')->get();
        if(!$departments)
          return ResponseHelper::serverError();
        return ResponseHelper::select($departments);
    }

    //Add department
   public function store(DepartmentRequest $request){
    $validated = $request->validated();
    $created = $this->department->createData($validated);
    if(!$created)
      return ResponseHelper::creatingFail();
     return ResponseHelper::create($created);
  }

 //Edit department
 public function updateD(DepartmentRequest $request, $id){
    $validated = $request->validated();
    $department = $this->department->find($id);
    if (!$department)
       return ResponseHelper::DataNotFound();
    $updated = $this->department->where('id',$id)->update($validated);
    if(!$updated)
       return ResponseHelper::updatingFail();
    return ResponseHelper::update($updated);
  }

  //Delete department
  public function deeleteDepartment($id)
  {
     $department = $this->department->find($id);
      if (!$department)
        return ResponseHelper::DataNotFound();
      $deleted = $department->delete();
      if (!$deleted)
         return ResponseHelper::deletingFail();
       return ResponseHelper::delete();
  }

  //add departments to my store
  public function addStoreDepartments(AddStoreDepartmentseRequest $request){
    $request->validated();
    $created = $this->storeDepartment->createStoreDepartments($request);
    if(!$created)
      return ResponseHelper::creatingFail();
     return ResponseHelper::create($created);
  }

  //delete department from my store
  public function deleteStoreDepartments($id){
    $storeDepartment = $this->storeDepartment->find($id);
    if (!$storeDepartment)
      return ResponseHelper::DataNotFound();
    $deleted = $storeDepartment->delete();
    if (!$deleted)
       return ResponseHelper::deletingFail();
     return ResponseHelper::delete();
  }

  //get  store departments
  public function myDepartmentStore($id){
    $departments = $this->storeDepartment->getMyStoreDepartments($id);
    if(!$departments)
      return ResponseHelper::serverError();
    return ResponseHelper::select($departments);
  }

  //Get generic products for this department
  public function generalDepartmentProducts($id){
    $selectId = $this->department->find($id);
    if (!$selectId)
        return ResponseHelper::DataNotFound($message = "invalid department id");
    $products = $this->storeProduct->generalProduct($id);
    if(!$products)
      return ResponseHelper::serverError();
    return ResponseHelper::select($products);
  }
}
