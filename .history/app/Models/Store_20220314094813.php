<?php
namespace App\Models;

use Kouja\ProjectAssistant\Bases\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Traits\ModelTrait;

class Store extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $table = '';

    protected $fillable = [];

    protected $hidden = [];

    protected $dates = [];

    protected $casts = [];

}
