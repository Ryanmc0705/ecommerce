<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $guarded = [];

    public function User(){
        return $this->hasMany(User::class);
    }
    public function Category(){
        return $this->hasMany(Category::class);
    }
    public function Brand(){
        return $this->hasMany(Brand::class);
    }
    public function Product(){
        return $this->hasMany(Product::class);
    }
    use HasFactory;
}
