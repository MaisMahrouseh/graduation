<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductDetail;
use App\Models\Product;
use App\Models\Store;
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

    
    public function getProducts($id){
        $data =  $this->select('id','store_id', 'department_id', 'product_id')
        ->where('store_id',$id)
        ->with(['product' => function($q){
            $q ->select('id','name','image');}])
        ->with(['department' => function($q){
             $q ->select('name','id');}])
        ->with(['productdetails' => function($q){
            $q ->join('unites', 'unites.id', '=', 'product_details.unite_id')
               ->leftJoin('solds', 'solds.product_detail_id', '=', 'product_details.id')
               ->select('price','store_product_id','batch_number','describe','unites.name as unite_name','unites.id as unite_id','solds.id as sold_id',
               'solds.new_price as discount Price','solds.start_date as discount start date','solds.end_date as discount end date')
            ;}])    
        ->get();
        return collect($data)->each(function ($dat) {
            unset($dat['store_id'],$dat['department_id'],$dat['product_id']);
        });
    }

    public function generalProduct($id){
        $data =   $this->select('product_id')
                    ->where('department_id', $id)
                    ->distinct()
                    ->get();
        return Product::select('id','name')->whereIn('id',$data)->get();
    }

    public function generalStores($id){
      $data =   $this->select('store_id')
                    ->where('product_id', $id)
                    ->distinct()
                    ->get();
       return Store::select('id','name')->whereIn('id',$data)->get();       
    }

    public function getCheapestProduct($id){
       return $this
               ->where('product_id',$id)
               ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
               ->join('stores', 'stores.id', '=', 'store_products.store_id')
               ->select('price','stores.id','stores.name','stores.logo')
               ->orderBy('price')
               ->get();
    }

    public function getClosestProduct($request,$id){
        return $this
        ->where('product_id',$id)
        ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
        ->join('stores', 'stores.id', '=', 'store_products.store_id')
        ->select('price','stores.id','stores.name','stores.logo', \DB::raw("6371 * acos(cos(radians(" . $request->locationX . "))
        * cos(radians(locationX)) * cos(radians(locationY) - radians(" . $request->locationY . "))
        + sin(radians(" .$request->locationX. ")) * sin(radians(locationX))) AS distance"))
        ->orderBy('distance')
        ->orderBy('price')
        ->get();
    }

}
