<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRegisterRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Product_Image;
use App\Models\SubCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRegisterRequest $request)
    {
        $product = Product::Create($request->only(
            "user_id",
            "company_id",
            "category_id",
            "sub_category_id",
            "name",
            "description",
            "price",
            "stocks",
            "product_code",
            "brand_id",
            "sale_percentage",
            "sale_until"
        ));
        $files = $request->file('file');
        if (!is_array($files)) {
            $files = [$files];
        }

        //loop throu the array 
        for ($i = 0; $i < count($files); $i++) {
            $file = $files[$i];
            $filename = $request->product_code.$i.$file->getClientOriginalName();
            $filename = str_replace(' ', '', $filename);
            $file_path = $file->storeAs('uploads', $filename, 'public');
            $product_image = new Product_Image();
            $product_image->image_path = '/storage/' . $file_path;
            if($i == 0){
                $product_image->type = "thumbnail";
            }else{
                $product_image->type = "others";
            }
            $product->Product_Image()->save($product_image);
        }

        return response([
            "message" => "Product Saved",
            "product" => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($filter_by, $id)
    {
        if ($filter_by == "company") {
            $products =  Company::findOrFail($id)
                                  ->Product()
                                  ->with(["Product_Image" => function($query){
                                        $query->select("product_id","image_path")->where("type","thumbnail");
                                  },"Category:id,name","Brand:id,name"])
                                  ->get(["id","category_id","sub_category_id","brand_id","name","product_code","description","stocks","price","featured","sale_percentage"]);
        } else if ($filter_by == "category") {
            $products = Category::findOrFail($id)->Product;
        } else {
            $products = SubCategory::findOrFail($id)->Product;
        }
        return response([
            "products" => $products,
           
        ]);
    }
    public function showProduct($product_id)
    {
        $product = Product::where("id",$product_id)
                           ->with(["Product_Image" => function($query){
                            $query->select("product_id","image_path","id")->where("type","others");
                            }])
                            ->get(["id","category_id","sub_category_id","brand_id","name","product_code","description","stocks","price","sale_percentage","sale_until"]);
        return response([
            "product" => $product
        ]);
    }
    public function showHome($page){
      
        $products_list = Product::with(["Brand:id,name","Product_Image"=>function($query){
                          $query->select("product_id","image_path")->where("type","thumbnail");
                                  }
                                  ,"Category:id,name"])
                                 ->get(["id","category_id","brand_id","name","description","price","stocks","sale_percentage","sale_until"]);
        $new_list = $products_list->map(function($product){
            $sale_percentage = $product->sale_percentage/100;
            $sale_price = $product->price - ($sale_percentage * $product->price);
            return[
                    "id" => $product->id,
                    "category_id" => $product->category_id,
                    "brand_id" => $product->brand_id,
                    "name" => $product->name,
                    "description" => $product->description,
                    "sale_price" => $sale_price,
                    "orig_price" => $product->price,
                    "sale_percentage" => $product->sale_percentage, 
                    "stocks" => $product->stocks,
                    "sale_until" => $product->sale_until,
                    "brand" => $product->brand["name"],
                    "product_image" => $product->Product_Image,
                    "category" => $product->Category
            ];
        });                       
        $products = Cache::remember("HomeLazyLoading",60*2,fn()=>$new_list);
        return response([
            "homeProducts" => $products->forPage($page,20)
        ]);
    }
    public function displayProductDetails($product_id)
    {
        $product = Product::where("id",$product_id)
                   ->with(["Category:id,name","Product_Image:product_id,image_path","Brand:name,id"])
                   ->get(["id","category_id","brand_id","name","description","price","stocks","sale_percentage","sale_until"]);
        return response(["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sale_percentage = $request->sale_percentage;
        $product->sale_until = $request->sale_until;
        $product->stocks = $request->stocks;
        $product->brand_id = $request->brand_id;
        $product->product_code = $request->product_code;
        $product->save();

        return response([
            "message" => "updated",
            "product" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Product::destroy($product_id);
        return response(["message" => "delete success"]);
    }
    public function updateFeatured(Request $request,$product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->featured = $request->featured;
        $product->save();
        return response([
            "message" => "success",
            "product" => $product
        ]);
    }
    public function getFeatured()
    {
        $products = new Product();
        $featured_products = $products->Featured()->with(["Brand:id,name","Product_Image"=>function($query){
            $query->select("product_id","image_path")->where("type","thumbnail");
                    }
                    ,"Category:id,name"])
                   ->limit(15)->get(["id","category_id","brand_id","name","description","price","stocks"]);
        return response([
            "featured_products" => $featured_products
        ]);
    }
}
