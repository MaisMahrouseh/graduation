<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Http\Requests\Store\SortLocationRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\FavoriteRequest;


class CartController extends Controller
{
    public $cart;
    public $product;
    public $storeProduct;
    public function __construct(Cart $cart,Product $product,StoreProduct $storeProduct)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->storeProduct = $storeProduct;
    }

    //add product to user's cart
    public function addTocart($id){
        $product =  $this->product->find($id);
        if (!$product)
           return ResponseHelper::DataNotFound($message = "invalid product id");
        $created = $this->cart->create([
            'user_id' => auth()->user()->id,
            'product_id' => $id,
        ]);
        if(!$created)
             return ResponseHelper::creatingFail();
        return ResponseHelper::create($created);
    }
    //the lowest price for the product
    public function cheapestProduct($id){
        $cheapes = $this->storeProduct->getCheapestProduct($id);
        if(!$cheapes)
          return ResponseHelper::serverError();
        return ResponseHelper::select($cheapes);
    }

    //the store closest to the product
    public function closestProduct(SortLocationRequest  $request,$id){
        $request->validated();
        $closest = $this->storeProduct->getClosestProduct($request,$id);
        if(!$closest)
          return ResponseHelper::serverError();
        return ResponseHelper::select($closest);
    }

    //get user cart
    public function getCart(){
        $carts = $this->cart->getUserCart();
        if(!$carts)
          return ResponseHelper::serverError();
        return ResponseHelper::select($carts);
    }

    //remove an item from the cart
    public function removeFromCart($id){
        $item =  $this->cart->find($id);
        if (!$item)
          return ResponseHelper::DataNotFound($message = 'Error in cart id');
        $deleted = $item->delete();
        if (!$deleted)
           return ResponseHelper::deletingFail();
         return ResponseHelper::delete();
    }

    public function cheapestCart(){
      $results = DB::table('store_products')
         ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
         ->leftJoin('stores', 'store_products.store_id', '=', 'stores.id')
         ->select('stores.name', 'stores.id','stores.logo',DB::raw('SUM(product_details.price) AS price'))
         ->whereIn('store_products.product_id',function($query)
           {
              $query->select('carts.product_id')
                    ->from('carts')
                    ->where('carts.user_id',auth()->user()->id)
                    ->get();
          })
         ->groupBy('stores.name','stores.id','stores.logo')
         ->havingRaw('sum(1) = (SELECT max(z.v) from (select sum(1) as v from store_products join carts on carts.product_id = store_products.product_id where carts.user_id =' . auth()->user()->id.' group by store_products.store_id) z)')
         ->orderBy('price')
         ->whereNull('product_details.deleted_at')
         ->get();
         if(!$results)
          return ResponseHelper::serverError();
        return ResponseHelper::select($results);
    }

    public function detailsResultCart(FavoriteRequest $request){
        $request->validated();
        $results = DB::table('store_products')
        ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
        ->leftJoin('products', 'store_products.product_id', '=', 'products.id')
        ->select('products.id as product_id', 'products.name as product_name','product_details.price as price')
        ->where('store_products.store_id',$request->store_id)
        ->whereIn('store_products.product_id',function($query)
        {
           $query->select('carts.product_id')
                 ->from('carts')
                 ->where('carts.user_id',auth()->user()->id)
                 ->get();
       })
       ->get();
       if(!$results)
          return ResponseHelper::serverError();
       return ResponseHelper::select($results);
    }

    public function nearestCart(SortLocationRequest $request){
        $request->validated();
        $results = DB::table('store_products')
        ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
        ->leftJoin('stores', 'store_products.store_id', '=', 'stores.id')
        ->select('stores.name', 'stores.id','stores.logo',DB::raw('SUM(product_details.price) AS price'),
        \DB::raw("6371 * acos(cos(radians(" . $request->locationX . "))
        * cos(radians(locationX)) * cos(radians(locationY) - radians(" . $request->locationY . "))
        + sin(radians(" .$request->locationX. ")) * sin(radians(locationX))) AS distance"))
        ->whereIn('store_products.product_id',function($query)
          {
             $query->select('carts.product_id')
                   ->from('carts')
                   ->where('carts.user_id',auth()->user()->id)
                   ->get();
         })
        ->groupBy('stores.name','stores.id','stores.logo','stores.locationX','stores.locationY')
        ->havingRaw('sum(1) = (SELECT max(z.v) from (select sum(1) as v from store_products join carts on carts.product_id = store_products.product_id where carts.user_id =' . auth()->user()->id.' group by store_products.store_id) z)')
        ->orderBy('distance')
        ->whereNull('product_details.deleted_at')
        ->get();
        if(!$results)
         return ResponseHelper::serverError();
       return ResponseHelper::select($results);
    }
}
