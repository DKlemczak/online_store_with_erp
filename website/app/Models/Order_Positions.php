<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Positions extends Model
{
    public $timestamps = false;
    protected $table = 'order_positions';

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id','id');
    }

    public function Product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
