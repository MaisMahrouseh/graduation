<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreDepartment extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'store_id', 'department_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

   public function createStoreDepartments($request){
        $this->create([
               'department_id' => $request->department_id,
               'store_id' => $request->store_id,
           ]);
       return true;
   }

   public function getMyStoreDepartments($id){
       return  $this->select('id','department_id')
                    ->where('store_id', $id)
                    ->join('departments', 'departments.id', '=', 'store_departments.department_id')
                    ->select('departments.name','departments.id')
                    ->get();
   }
}
