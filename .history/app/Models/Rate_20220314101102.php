<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends BaseModel
{
    use HasFactory;

    protected $table = '';

    protected $fillable = [];

    protected $hidden = [];

    protected $dates = [];

    protected $casts = [];

}
