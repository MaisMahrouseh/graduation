<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Rate;
use App\Models\Cart;
use App\Models\User;
use App\Models\UserSearch;
use App\Http\Requests\User\FavoriteRequest;
use App\Http\Requests\User\RateRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\User\SearchRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ActivityController extends Controller
{
    public $favorite;
    public $rate;
    public $cart;
    public $user;
    public $userSearch;
    public function __construct(Favorite $favorite , Rate $rate ,Cart $cart , User $user,UserSearch $userSearch)
    {
        $this->favorite = $favorite;
        $this->rate = $rate;
        $this->cart = $cart;
        $this->user = $user;
        $this->userSearch = $userSearch;
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

    //Change the user's password by sending the old password and the new password
    public function changePassword(ChangePasswordRequest $request){
        $request->validated();
        $olaPassword = $this->user->find(auth()->user()->id)->password;
        if (!Hash::check($request->oldPassword, $olaPassword)) {
            return ResponseHelper::operationFail($message = "your password is incorrect");
        }
        $update = $this->user->editPassword($request);
        if(!$update)
        return ResponseHelper::updatingFail();
     return ResponseHelper::update($update);
    }

    public function storingSearchUser(SearchRequest $request){
        $request->validated();
        $created = $this->userSearch->create([
            'text' => $request->text,
            'user_id' => auth()->user()->id,
        ]);
        if(!$created)
        return ResponseHelper::creatingFail();
      return ResponseHelper::create($created);
    }

    public function recentSearchResults(){
        $recent = $this->userSearch->getRecentSearchResults();
        if(!$recent)
             return ResponseHelper::serverError();
        return ResponseHelper::select($recent);
    }

    public function mostSearched(){
        $recent = $this->userSearch->getmostSearched();
        if(!$recent)
             return ResponseHelper::serverError();
        return ResponseHelper::select($recent);
    }


    public function usersInfo(){
    $data = User::select("id","email","phone", DB::raw("CONCAT(users.firstname,' ',users.lastname) as full_name"))
    ->get();
        if(!$data)
             return ResponseHelper::serverError();
        return ResponseHelper::select($data);
    }




}
