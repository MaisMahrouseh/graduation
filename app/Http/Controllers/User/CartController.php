<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\StoreProduct;
use App\Http\Requests\Store\SortLocationRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
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
      //  $cheapes =  $this->cart->getUserCart();
      //  $m = $cheapes->product_id;

        //ضمن متاجر مختلفة
      /*  $this->storeProduct->where('product_id',$id)
        ->join('product_details', 'product_details.store_product_id', '=', 'store_products.id')
        ->join('stores', 'stores.id', '=', 'store_products.store_id')
        ->select('price','stores.id','stores.name','stores.logo')
        ->orderBy('price')
        ->get();*/




        //if(!$cheapes)
        //  return ResponseHelper::serverError();
        return ResponseHelper::select($m);
    }
}
