<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function Product_Image(){
        return $this->hasMany(Product_Image::class);
    }
    public function scopeFeatured(Builder $query){
        return $query->where("featured","=","1");
    }
    public function getSalePriceAttribute(){
        $sale_percentage = $this->sale_percentage / 100;
        return $this->price - ($sale_percentage * $this->price);
    }
    
}
