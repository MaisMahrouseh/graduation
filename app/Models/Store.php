<?php
namespace App\Models;

use Kouja\ProjectAssistant\Bases\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserStore;

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

    public function storedepartments()
    {
        return $this->hasMany(StoreDepartment::class);
    }

    public function addStore($request){
        $picture = $request->file('logo');
        if($request->hasFile('logo')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/StoreImages'),$picturename);
            $created = $this->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'locationX' => $request->locationX,
                'locationY' => $request->locationY,
                'logo' => $picturename,
            ]);}
            return $created;
    }
    
    public function allowAddStore($request){
        $this->where('id',$request->store_id)->update([
            'allow' => 1,
        ]);
        return UserStore::create([
            'user_id' => $request->user_id,
            'store_id' => $request->store_id,
        ]); 
    }




}
