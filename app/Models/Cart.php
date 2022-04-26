<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'user_id', 'product_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUserCart(){
        return $this->where('user_id',auth()->user()->id)
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->select('carts.id as cart_id','name','image','products.id as product_id')
                    ->get();
    }


}
