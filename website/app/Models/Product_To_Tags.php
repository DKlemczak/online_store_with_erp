<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_To_Tags extends Model
{
    public $timestamps = false;

    public function Products()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }

    public function Products_Tags()
    {
        return $this->belongsTo(Products_Tags::class, 'tag_id','id');
    }
}
