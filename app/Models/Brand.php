<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    protected $guarded = [];
    use HasFactory, SoftDeletes;
    public function Company()
    {
        $this->belongsTo(Company::class);
    }

    public function Product()
    {
       return  $this->hasMany(Product::class);
    }
}
