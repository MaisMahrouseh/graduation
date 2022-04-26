<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sold extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'new_price', 'product_detail_id','start_date','end_date'];

    protected $dates = ['start_date','end_date'];

    public function productdetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

    public function getSolds(){
        return  $this
               ->join('product_details', 'product_details.id', '=', 'solds.product_detail_id')
               ->join('store_products', 'store_products.id', '=', 'product_details.store_product_id')
               ->join('stores', 'stores.id', '=', 'store_products.store_id')
               ->join('products', 'products.id', '=', 'store_products.product_id')
               ->select('products.name as product_name','products.image as product_image','stores.name as store_name',
                       'product_details.price as old_price','new_price','start_date', 'end_date', )     
        ->get();

    }

}
