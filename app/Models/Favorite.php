<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Favorite extends BaseModel
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

    public function favoriteActivate($data)
    {
        $data['user_id'] = Auth::id();
        $Favorite = $this->findData($data);
        if (collect($Favorite)->isEmpty()){ 
            $Favorite = $this->createData($data);
        }
        else{
        $Favorite->delete();
        }  
        return $Favorite;
    }

    public function getMyFavorite(){
        return $this->select('user_id','store_id')
        ->join('stores', 'stores.id', '=', 'favorites.store_id')
             ->select('stores.id','stores.name','stores.logo')
             ->where('stores.allow',1)
             ->where('favorites.user_id',auth()->user()->id)
    ->get();
    }


}
