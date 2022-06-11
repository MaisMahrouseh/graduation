<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStore extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id','user_id','store_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getMyStores(){
        return $this->select('user_id','store_id')
                ->join('stores', 'stores.id', '=', 'user_stores.store_id')
                ->select('stores.id','stores.name','stores.logo')
                ->where('stores.allow',1)
                ->where('user_stores.user_id',auth()->user()->id)
                ->get();
     }

     public function getExistingStores(){
        return $this->select('store_id', 'user_id')
                ->join('stores', 'stores.id', '=', 'user_stores.store_id')
                ->join('users', 'users.id', '=', 'user_stores.user_id')
                ->select('stores.id as store_id','stores.name','stores.logo','stores.phone',
                'stores.created_at  as date_join','stores.allow','users.id as user_id','stores.deleted_at as delet_date')
                ->orderBy('allow')
                ->get();
     }

}
