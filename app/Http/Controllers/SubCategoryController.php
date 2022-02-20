<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|unique:sub_categories",
            "category_id" => "required"
        ]);
        $subCategory = SubCategory::create($request->only("name","category_id"));
        return response([
            "message" => "success",
            "sub-category" => $subCategory
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show($category_id)
    {
        $subCategory = Category::findOrFail($category_id)->SubCategory()->get(["id","name","created_at"]);
        return  response([
            "subcategories" => $subCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$sub_id)
    {
        $subCategory = SubCategory::findOrFail($sub_id);
        $subCategory->name = $request->name;
        $subCategory->save();
        return response([
            "message"=>"update success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($sub_id)
    {
        $subCategory = SubCategory::where("id",$sub_id)->delete();
        return response(["message" => "success"]);
    }
}
