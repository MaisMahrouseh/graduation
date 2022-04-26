<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sold;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
class SoldController extends Controller
{
    public $sold;
    public function __construct(Sold $sold)
    {
        $this->sold = $sold;
    }

    //get all discounts and store them
    public function allSolds(){
        $solds = $this->sold->getSolds();
        if(!$solds)
          return ResponseHelper::serverError();
        return ResponseHelper::select($solds);
    }
}
