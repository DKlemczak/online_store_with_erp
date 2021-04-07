<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_To_Tags extends Model
{
    public $timestamps = false;
    protected $table = 'product_to_tags';

    public function Products()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function Products_Tags()
    {
        return $this->belongsTo(ProductsTags::class, 'products_tags_id', 'id');
    }
}
