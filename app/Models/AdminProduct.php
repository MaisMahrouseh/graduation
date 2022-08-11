<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kouja\ProjectAssistant\Bases\BaseModel;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminProduct extends BaseModel
{
    use HasFactory ,SoftDeletes, ModelTrait;

    protected $fillable = ['id','text','image'];


    public function addproduct($request){
        $picture = $request->file('image');
        if($request->hasFile('image')){
            $picturename = rand().'.'.$picture->getClientOriginalExtension();
            $picture->move(public_path('images/suggestionProducts'),$picturename);
            $picturename = 'https://mais-api.preneom.com/public/images/ProductImages/'.(string)$picturename;
            $created = $this->create([
                'text' => $request->text,
                'image' => $picturename,
            ]);}
            return $created;
    }

}
