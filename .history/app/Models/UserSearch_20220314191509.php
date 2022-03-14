<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSearch extends BaseModel
{
    use HasFactory,SoftDeletes, ModelTrait;

    protected $table = '';

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
