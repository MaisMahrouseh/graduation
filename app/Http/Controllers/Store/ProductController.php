<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\AdminProduct;
use App\Http\Requests\Store\ProductRequest;
use App\Http\Requests\Store\NotExistProductRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;

class ProductController extends Controller
{
    public $product;
    public $adminProduct;
    public function __construct(Product $product, AdminProduct $adminProduct)
    {
        $this->product = $product;
        $this->adminProduct = $adminProduct;
    }

    //show all products
    public function index()
    {
        $products = $this->product->getProduct();
        if(!$products)
          return ResponseHelper::serverError();
        return ResponseHelper::select($products);
    }

  //Add product
   public function store(ProductRequest $request)
   {
     $request->validated();
     $created = $this->product->addProduct($request);
      if(!$created)
        return ResponseHelper::creatingFail();
      return ResponseHelper::create($created);
    } 
  
   //Delete product
  public function destroy($id)
  {
     $product =  $this->product->find($id);
     if (!$product)
        return ResponseHelper::DataNotFound();
     $deleted = $product->delete();
     if (!$deleted)
           return ResponseHelper::deletingFail();
      return ResponseHelper::delete();
  }

  //Edit product
  public function updateP(ProductRequest $request, $id){
    $request->validated();
    $product = $this->product->find($id);
    if (!$product)
        return ResponseHelper::DataNotFound();
   $updated = $this->product->updateProduct($request ,$id);
   if(!$updated)
       return ResponseHelper::updatingFail();
    return ResponseHelper::update($updated);
  }

  //Suggestion to add a product that does not exist
  public function notExistProduct(NotExistProductRequest $request){
    $validated = $request->validated();
    $created = $this->adminProduct->createData($validated);
    if (!$created)
        return ResponseHelper::creatingFail();
    return ResponseHelper::operationSuccess($data = "Operation completed successfully, please wait for permission");
  }
}
