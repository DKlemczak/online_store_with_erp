<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products_Group extends Model
{
    public $timestamps = false;
    protected $table = 'products_group';

    public function Products()
    {
        return $this->hasMany(Products::class,'group_id','id');
    }

    public function Products_Group()
    {
        return $this->hasMany(Products_Group::class,'group_id','id');
    }
}
