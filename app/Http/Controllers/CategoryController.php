<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:categories",
            "company_id" => "required"
        ]);
        $category = Category::create($request->only("name","company_id"));
        return response(["category"=>$category,
                        "message" => "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($company_id)
    {
        $company_catagories = Company::findOrFail($company_id)->Category()->withCount("SubCategory")->get(["name","id","created_at"]);
        return response([
            "categories" => $company_catagories
        ]);
                
    }
    public function showToHome(){
        $categories = Category::with(["SubCategory:category_id,id,name"])->get(["id","name"]);
        return response(["categories" => $categories]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$category_id)
    {
        $category = Category::findOrFail($category_id);
        $category->name = $request->name;
        $category->save();
        return response([
            "category" => $category,
            "message" => "success"
        ]);
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category,$category_id)
    {
        $categories = $category->where("id",$category_id)->delete();
        return response([
            "message" => "success",
            "deleted category" => $categories
        ]);
    }
}
