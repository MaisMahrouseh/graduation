<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sold extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = [];

    protected $dates = [];

    public function productdetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }

}
