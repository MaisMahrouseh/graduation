<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductDetail;
use App\Models\Sold;

class StoreProduct extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'store_id', 'department_id', 'product_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productdetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function addStoreProduct($request){
        $storeProduct = $this->create([
            'store_id' => $request->store_id,
            'department_id' => $request->department_id,
            'product_id' => $request->product_id,
        ]);
        $storeProductId =  $storeProduct->id;
        $productDetails = ProductDetail::create([
            'store_product_id' => $storeProductId,
            'unite_id' => $request->unite_id,
            'price' => $request->price,
            'batch_number' => $request->batch_number,
            'describe' => $request->describe,
        ]);
        $productDetailsId = $productDetails->id;
        if($request->has('new_price')){
           $sold = Sold::create([
             'product_detail_id' => $productDetailsId,
             'start_date' => $request->start_date,
             'end_date' => $request->end_date,
             'new_price' => $request->new_price,
         ]);
      }
        return true;
    }
}
