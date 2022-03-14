<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;

class Favorite extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $table = '';

    protected $fillable = [];

    protected $hidden = [];

    protected $dates = [];

    protected $casts = [];

}
