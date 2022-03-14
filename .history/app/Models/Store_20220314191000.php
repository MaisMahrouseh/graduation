<?php
namespace App\Models;

use Kouja\ProjectAssistant\Bases\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'name' ,'phone','locationX','locationY','logo' ,'allow'];

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userstores()
    {
        return $this->hasMany(UserStore::class);
    }

    public function storeproducts()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function storedepartment()
    {
        return $this->hasMany(StoreDepartment::class);
    }


}
