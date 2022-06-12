<?php
namespace App\Models;

use Kouja\ProjectAssistant\Bases\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserStore;
use App\Models\Department;
use App\Models\StoreDepartment;

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
            $picturename = "https://mais-api.preneom.com/public/images/StoreImages/"+$picturename;
            $created = $this->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'locationX' => $request->locationX,
                'locationY' => $request->locationY,
                'logo' => $picturename,
            ]);}
            $storeId = $created->id;
            UserStore::create([
                'user_id' => auth()->user()->id,
                'store_id' => $storeId,
            ]);
            return $created;
    }


    public function getDetails($id){
      $details =  $this->select('id','name','logo','phone','locationX','locationY')->where('id', $id)
        ->with(['storedepartments' => function($q){
            $q ->join('departments', 'departments.id', '=', 'store_departments.department_id')
               ->select('departments.name','store_id','store_departments.id');
        }])->get();
      $departments = Department::select('id','name')
           ->whereNotIn('id',StoreDepartment::select('department_id')->where('store_id',$id)->get())
           ->get();
        return [$details, $departments];
       }

    public function getStores(){
        $stores = $this->select('id', 'name', 'logo')
            ->where('allow',1)
            ->get();

        return collect($stores)->each(function ($store) {
            $store['rate'] = collect($store['rates'])->avg('rate');
            unset($store['rates']);
        });
    }

    public function storeInfo($id){
        return $this->select('name' ,'phone','locationX','locationY','logo')
        ->where('id', $id)
        ->where('allow',1)
        ->get();
    }

    public function getSortStoresLocation($request){
        $stores = $this->select("name","id","logo", \DB::raw("6371 * acos(cos(radians(" . $request->locationX . "))
        * cos(radians(locationX)) * cos(radians(locationY) - radians(" . $request->locationY . "))
        + sin(radians(" .$request->locationX. ")) * sin(radians(locationX))) AS distance"))
        //->having('distance', '<', 1000)
        ->orderBy('distance')
        ->where('allow',1)
        ->get();
        return collect($stores)->each(function ($store) {
            $store['rate'] = collect($store['rates'])->avg('rate');
            unset($store['rates']);
        });

    }

}
