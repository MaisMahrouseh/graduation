<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSearch extends BaseModel
{
    use HasFactory,SoftDeletes, ModelTrait;

    protected $fillable = ['id','text','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRecentSearchResults(){
        return $this->select('text')->where('user_id',auth()->user()->id)->latest()->take(3)->get();
    }

    public function getmostSearched(){
        return $this->select('text')->groupBy('text')->orderByRaw('count(*) DESC')->limit(3)->get();
    }


}
