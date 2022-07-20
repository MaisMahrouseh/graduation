<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'name', 'image', 'product_id','barcode'];

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
        return $this->hasMany(Product::class, 'product_id');
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function addProduct($request){
        $picture = $request->file('image');
        if($request->hasFile('image')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/ProductImages'),$picturename);
            $picturename = 'https://mais-api.preneom.com/public/images/ProductImages/'.(string)$picturename;
            $created = $this->create([
                'name' => $request->name,
                'image' => $picturename,
                'barcode' => $request->barcode,
                'product_id' => $request->product_id,
            ]);}
            return $created;
    }

    public function getProduct(){
    return DB::table('products as A')
           ->leftJoin('products as B', 'A.product_id', '=', 'B.id')
           ->select('A.id as product_id','A.name','A.image','A.barcode', 'B.name AS parent')
           ->whereNull('A.deleted_at')
           ->orderBy('parent')
           ->get();
    }

    public function updateProduct($request ,$id){
        $picture = $request->file('image');
        if($request->hasFile('image')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/ProductImages'),$picturename);
            $picturename = 'https://mais-api.preneom.com/public/images/ProductImages/'.(string)$picturename;
            $updated = $this->where('id',$id)->update([
                'name' => $request->name,
                'image' => $picturename,
                'barcode' => $request->barcode,
                'product_id' => $request->product_id,
            ]);}
            return $updated;
    }
}
