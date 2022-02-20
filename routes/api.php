<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\SubCategoryController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix("/user")->group(function(){
    Route::post("/create",[AuthController::class,"store"])->name("user.create");
    Route::post("/login",[AuthController::class,"login"])->name("user.login");
});
Route::get("product/show/featured",[ProductController::class,"getFeatured"])->name("product.show.featured");
Route::get("product/details/display/{product_id}",[ProductController::class,"displayProductDetails"])->name("product.show.details");
Route::get("homeproduct/{page}",[ProductController::class,"showHome"])->name("product.home");
Route::get("brand/",[BrandController::class,"index"])->name("brand.show");
Route::get("category/show/hompage",[CategoryController::class,"showToHome"])->name("category.show.home");

Route::group(["middleware"=>["auth:sanctum"]],function(){
    Route::get("/test",function(){
        return "test sanctum";
    });
    Route::prefix("/user")->group(function(){
        Route::get("/logout",[AuthController::class,"logout"])->name("user.logout");
    });
    Route::prefix("/productimage")->group(function(){
        Route::post("",[ProductImageController::class,"store"])->name("productimage.store");
        Route::delete("/{image_id}",[ProductImageController::class,"destroy"])->name("productimage.destry");
    });
    Route::prefix("category")->group(function(){
        Route::post("/create",[CategoryController::class,"store"])->name("category.create");
        Route::put("/{category_id}",[CategoryController::class,"update"])->name("category.update");
        Route::delete("/{category_id}",[CategoryController::class,"destroy"])->name("category.destroy");
        Route::get("/{company_id}",[CategoryController::class,"show"])->name("category.show");
        
    });
    Route::prefix("subcategory")->group(function(){
        Route::post("/create",[SubCategoryController::class,"store"])->name("subcategory.create");
        Route::put("/{category_id}",[SubCategoryController::class,"update"])->name("subcategory.update");
        Route::delete("/{category_id}",[SubCategoryController::class,"destroy"])->name("subcategory.destroy");
        Route::get("/{company_id}",[SubCategoryController::class,"show"])->name("subcategory.show");
    });
    Route::prefix("product")->group(function(){
        Route::put("/featured/{product_id}",[ProductController::class,"updateFeatured"])->name("product.update.featured");
        
    });
    Route::resource("product",ProductController::class)->only(["store","update","destroy"]);
    Route::resource("brand",BrandController::class)->only(["store","update","show","destroy"]);
    Route::get("product/{filter}/{company_id}",[ProductController::class,"show"])->name("product.show");
    Route::get("/singleproduct/{product_id}",[ProductController::class,"showProduct"])->name("show.single");
    
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
