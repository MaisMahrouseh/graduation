<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Store;


class StatisticsController extends Controller
{

    public function favoritStores(){
        $data =  Favorite::join('stores', 'stores.id', '=', 'favorites.store_id')
        ->select(DB::raw('count(*) as count, store_id'),'stores.name')
        ->groupBy('store_id','name')
        ->orderBy('count','desc')
        ->get();
        if(!$data)
          return ResponseHelper::serverError();
        return ResponseHelper::select($data);
    }
    public function usersCount(){
        $data =  User::count();
        if(!$data)
          return ResponseHelper::serverError();
        return ResponseHelper::select($data);
    }

    public function storesCount(){
        $data =  Store::where('allow',1)->count();
        if(!$data)
          return ResponseHelper::serverError();
        return ResponseHelper::select($data);
    }

}
