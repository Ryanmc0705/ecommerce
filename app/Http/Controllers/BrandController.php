<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Company;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            "brands" => Brand::all(["name","id","image"])
        ]);
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
            "name" => "required|unique:brands"
        ]);
        try {
            \DB::beginTransaction();

            if ($request->file()) {
                $brand = new Brand();
                $brand->company_id = $request->company_id;
                $brand->name = $request->name;
                $file_name = $request->name . '_' . $request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('uploads', $file_name, 'public');
                $brand->image = '/storage/' . $file_path;
                $brand->save();
                
            }
            \DB::commit();
            return response()->json(['success' => 'File uploaded successfully.'], 200);
        } catch (\Throwable $e) {
            \DB::rollback();

            response([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($company_id)
    {
        $brands = Company::findOrFail($company_id)->Brand()->get(["name","id","image"]);
        return response()->json([
            "brands" => $brands
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
