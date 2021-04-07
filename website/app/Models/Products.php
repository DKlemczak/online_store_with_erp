<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps = false;
    protected $table = 'products';

    public function Product_Photos()
    {
        return $this->hasMany(Product_Photos::class,'product_id','id');
    }

    public function Products_Group()
    {
        return $this->belongsTo(Products_Group::class,'group_id');
    }

    public function Products_Tags()
    {
        return $this->belongsToMany(ProductsTags::class, 'product_to_tags');
    }
}
