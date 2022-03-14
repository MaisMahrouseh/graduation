<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'name'];

    public function storedepartments()
    {
        return $this->hasMany(StoreDepartment::class);
    }

    public function storeproducts()
    {
        return $this->hasMany(StoreProduct::class);
    }
}
