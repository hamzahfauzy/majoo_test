<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    function images()
    {
        return $this->belongsToMany(Image::class,'product_images');
    }

    function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories');
    }
    
    function user()
    {
        return $this->belongsToMany(User::class,'product_users');
    }

    function getPriceFormatAttribute()
    {
        return number_format($this->price);
    }
}
