<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unite;
use App\Http\Requests\Store\AddUniteRequest;
use App\Http\Requests\Store\EditUniteRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;

class UniteController extends Controller
{
    public $unite;

    public function __construct(Unite $unite)
    {
        $this->unite = $unite;
    }

    //show all unites
    public function index()
    {
        $unites = $this->unite->getData();
        if(!$unites)
          return ResponseHelper::serverError();
        return ResponseHelper::select($unites);
    }

    //Add unite
   public function store(AddUniteRequest $request){
    $validated = $request->validated();
    $created = $this->unite->createData($validated);
    if(!$created)
      return ResponseHelper::creatingFail();
     return ResponseHelper::create($created);
}  

 //Edit unite
 public function updateu(EditUniteRequest $request, $id){
    $validated = $request->validated();
    $unite = $this->unite->find($id);
    if (!$unite)
       return ResponseHelper::DataNotFound();
    $updated = $this->unite->where('id',$id)->update($validated);
    if(!$updated)
       return ResponseHelper::updatingFail();
    return ResponseHelper::update($updated);
  }

  //Delete unite
  public function destroy($id)
  {
     $unite =  $this->unite->find($id);
      if (!$unite)
        return ResponseHelper::DataNotFound();
      $deleted = $unite->delete();
      if (!$deleted)
         return ResponseHelper::deletingFail();
       return ResponseHelper::delete();
  }

}
