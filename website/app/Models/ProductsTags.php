<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsTags extends Model
{
    public $timestamps = false;
    protected $table = 'productstags';


    public function Products()
    {
        return $this->belongsToMany(Products::class, 'product_to_tags');
    }
}
