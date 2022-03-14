<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sold extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $table = '';

    protected $fillable = [];

    public function unit()
    {
        return $this->belongsTo(Unite::class);
    }

}
