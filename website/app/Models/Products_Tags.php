<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products_Tags extends Model
{
    public $timestamps = false;
    protected $table = 'products_tags';


    public function Products()
    {
        return $this->belongsToMany(Products::class, 'product_to_tags');
    }
}
