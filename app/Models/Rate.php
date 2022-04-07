<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id','user_id','store_id','rate'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function getMyRates(){
       return $this->select('user_id','store_id')
        ->join('stores', 'stores.id', '=', 'rates.store_id')
             ->select('stores.id','stores.name','stores.logo','rates.rate')
             ->where('stores.allow',1)
             ->where('rates.user_id',auth()->user()->id)
             ->get();
    }
}
