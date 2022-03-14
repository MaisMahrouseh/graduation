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

    public function Department()
    {
        return $this->belongsTo(Department::class);
    }

}
