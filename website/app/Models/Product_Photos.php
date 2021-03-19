<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Photos extends Model
{
    public $timestamps = false;
    protected $table = 'product_photos';

    public function Products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
