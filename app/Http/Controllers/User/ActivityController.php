<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Rate;
use App\Models\Cart;
use App\Models\User;
use App\Http\Requests\User\FavoriteRequest;
use App\Http\Requests\User\RateRequest;
use App\Http\Requests\User\EditProfileRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public $favorite;
    public $rate;
    public $cart;
    public $user;
    public function __construct(Favorite $favorite , Rate $rate ,Cart $cart , User $user)
    {
        $this->favorite = $favorite;
        $this->rate = $rate;
        $this->cart = $cart; 
        $this->user = $user; 
    }

    //Add or remove a store to my favourites
    public function favorite(FavoriteRequest $request){
        $data = $request->validated();
        $created = $this->favorite->favoriteActivate($data);
        if(!$created)
          return ResponseHelper::creatingFail();
        return ResponseHelper::create();
    }

    //get user's favorite stores
    public function myFavorite(){
        $favorites = $this->favorite->getMyFavorite();
        if(!$favorites)
             return ResponseHelper::serverError();
        return ResponseHelper::select($favorites);
    }

    //Add or modify store rating
    public function rate(RateRequest $request){
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $filter = $data;
        unset($filter['rate']);
        $Rate = $this->rate->updateOrCreateData($filter, $data);
        if ($Rate == null) {
            return ResponseHelper::creatingFail();
        }
        return ResponseHelper::create();
    }

    //get user ratings for stores
    public function myRate(){
        $userRates = $this->rate->getMyRates();
        if(!$userRates)
             return ResponseHelper::serverError();
        return ResponseHelper::select($userRates);
    }

    //get user profile
    public function getMyProfile(){
        $profile = $this->user->userProfile();
        if(!$profile)
             return ResponseHelper::serverError();
        return ResponseHelper::select($profile);
    }

    //edit user Profile
    public function editMyProfile(EditProfileRequest $request){
        $request->validated();
        $update = $this->user->editUserProfile($request);
        if(!$update)
           return ResponseHelper::updatingFail();
        return ResponseHelper::update($update);
    }




}
