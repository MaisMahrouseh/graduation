<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\AdminProduct;
use App\Models\StoreProduct;
use App\Models\ProductDetail;
use App\Http\Requests\Store\ProductRequest;
use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\Store\NotExistProductRequest;
use App\Http\Requests\Store\ProductDepartmentRequest;
use App\Http\Requests\Store\UpdatePriceRequest;
use Kouja\ProjectAssistant\Helpers\ResponseHelper;
use App\Http\Requests\Store\UpdateProductRequest;

class ProductController extends Controller
{
    public $product;
    public $adminProduct;
    public $store;
    public $storeProduct;
    public function __construct(Product $product, AdminProduct $adminProduct , Store $store, StoreProduct $storeProduct, ProductDetail $productDetail)
    {
        $this->product = $product;
        $this->adminProduct = $adminProduct;
        $this->store = $store;
        $this->storeProduct = $storeProduct;
        $this->productDetail = $productDetail;
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
  public function deleteProduct($id)
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
  public function updateP(UpdateProductRequest $request, $id){
    $request->validated();
    if(!$request->hasFile('image')){
    $picture = $this->product->select('image')->where('id',$id)->first();
    $updated = $this->product->where('id',$id)->update([
        'name' => $request->name,
        'image' => $picture->image,
        'barcode' => $request->barcode,
        'product_id' => $request->product_id,
    ]);
    return ResponseHelper::update($updated);
  }
    $picture = $request->file('image');
    if($request->hasFile('image')){
       $picturename = rand().'.'.$picture->getClientOriginalExtension();
       $picture->move(public_path('images/ProductImages'),$picturename);
       $picturename = 'https://mais-api.preneom.com/public/images/ProductImages/'.(string)$picturename;
       $updated = $this->where('id',$id)->update([
              'name' => $request->name,
               'image' => $picturename,
               'barcode' => $request->barcode,
            'product_id' => $request->product_id,
        ]);}
     return ResponseHelper::update($updated);
  }

  //Suggestion to add a product that does not exist
  public function notExistProduct(NotExistProductRequest $request){
     $request->validated();
    $created = $this->adminProduct->addproduct($request);
    if (!$created)
        return ResponseHelper::creatingFail();
    return ResponseHelper::operationSuccess($data = " تمت العملية بنجاح, الرجاء الانتظار حتى يتم القبول او الرفض");
  }

  public function getAdminProducts(){
    $products = $this->adminProduct->select('id','text','image','created_at as add_date')->get();
    if(!$products)
      return ResponseHelper::serverError();
    return ResponseHelper::select($products);
  }

  //search product
  public function search(SearchRequest $request){
    $request->validated();
    $data = $this->product->select('id','name','image','barcode')
                 ->where("name","LIKE","%{$request->text}%")
                 ->get();
     return ResponseHelper::select($data);
     return ResponseHelper::serverError();
  }

  //Get all products (product name-unite-price-batch number-description-photo-its department-discount (start date-end date-price))
  public function myStoreProducts($id){
    $selectId = $this->store->find($id);
    if (!$selectId)
        return ResponseHelper::DataNotFound($message = "المعرّف غير موجود");
    $selected = $this->storeProduct->getProducts($id);
    if ($selected == null)
        return ResponseHelper::serverError();
    return ResponseHelper::select($selected);
  }
  //delete product from my store
  public function deleteMyStoreProducts($id){
    $product =  $this->storeProduct->find($id);
    if (!$product)
      return ResponseHelper::DataNotFound($message = "المعرّف غير موجود");
    $deleted = $product->delete();
    if (!$deleted)
       return ResponseHelper::deletingFail();
     return ResponseHelper::delete();
  }

  public function editAllPrices(UpdatePriceRequest $request){
    $request->validated();
    $percent = $request->percent /100;
    $items =  $this->productDetail
      ->join('store_products', 'store_products.id', '=', 'product_details.store_product_id')
      ->select('product_details.id')
      ->where('store_products.store_id',$request->store_id)
      ->get();
     foreach($items as $item){
        $item = ProductDetail::where('id',$item->id)->first();
        $item->price = $item->price * $percent;
        $item->save();
       }
       return ResponseHelper::operationSuccess($data = "تمت اكتمال العملية بنجاح");
  }

  //Get all the products of a specific department for a specific store
  public function storeDepartmentProducts(ProductDepartmentRequest $request){
  /*  $request->validated();
    $products = clone $this->storeProduct->getProducts($request->store_id)->where('department_id',$request->department_id);
    if(!$products)
      return ResponseHelper::serverError();
    return ResponseHelper::select($products);*/
  }
}
