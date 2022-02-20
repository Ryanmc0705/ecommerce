<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $guarded = [];
    use HasFactory,SoftDeletes;
    
    public function Company(){
        return $this->belongsTo(Company::class);
    }
    public function SubCategory(){
        return $this->hasMany(SubCategory::class);
    }
    public function Product()
    {
        return $this->hasMany(Product::class);
    }
}
