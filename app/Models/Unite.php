<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unite extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at',];

    public function productdetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

}
