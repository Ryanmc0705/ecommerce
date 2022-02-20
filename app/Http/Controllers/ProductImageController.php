<?php

namespace App\Http\Controllers;

use App\Models\Product_Image;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->file()) {
            $p_image = new Product_Image();
            $p_image->product_id = $request->product_id;
            $file_name = $request->name . '-' . $request->file('file')->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
            $p_image->image_path = '/storage/' . $file_path;
            $p_image->type = "others";
            $p_image->save();
        }
       
    }
    public function destroy($image_id)
    {
        $p_image = Product_Image::findOrFail($image_id);
        $productImage = str_replace('/storage', '', $p_image->image_path);
        Storage::delete('/public' . $productImage);
        
        $p_image->delete();
        
        return response([
            "message" => "delete",
            "image" => $p_image
        ]);
    }
}
