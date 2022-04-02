<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\Store\DepartmentRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;

class DepartmentController extends Controller
{
    public $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    //show all departments
    public function index()
    {
        $departments = $this->department->getData();
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
  public function destroy($id)
  {
     $department = $this->department->find($id);
      if (!$department)
        return ResponseHelper::DataNotFound();
      $deleted = $department->delete();
      if (!$deleted)
         return ResponseHelper::deletingFail();
       return ResponseHelper::delete();
  }
}
