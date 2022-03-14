<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use SebastianBergmann\CodeCoverage\Report\Xml\Unit;

class ProductDetail extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = [];

    public function storeproduct()
    {
        return $this->belongsTo(StoreProduct::class);
    }

    public function unit()
    {
        return $this->belongsTo(uni::class);
    }
}
