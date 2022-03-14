<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'name', 'image', 'product_id '];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function storeproducts()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function children()
    {
        return $this->hasMany(Product::class, 'pr');
    }

}
