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

    protected $fillable = ['id', 'name', 'image', 'product_id'];

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
            $created = $this->create([
                'name' => $request->name,
                'image' => $picturename,
                'product_id' => $request->product_id,
            ]);}
            return $created;
    }

    public function getProduct(){
    return DB::select("SELECT a.id,a.name,a.image,b.name as parent FROM products a
    LEFT OUTER JOIN products b  on a.product_id = b.id   WHERE a.deleted_at IS  NULL");
    }

    public function updateProduct($request ,$id){
        $picture = $request->file('image');
        if($request->hasFile('image')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/ProductImages'),$picturename);
            $updated = $this->where('id',$id)->update([
                'name' => $request->name,
                'image' => $picturename,
                'product_id' => $request->product_id,
            ]);}
            return $updated;
    }
}
