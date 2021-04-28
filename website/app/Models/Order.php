<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';

    public function Positions()
    {
        return $this->hasMany(Order::class, 'order_id','id');
    }

    public function Payment()
    {
        return $this->hasOne(Payment_Type::class);
    }

    public function Transport()
    {
        return $this->hasOne(Transport_Type::class);
    }
}
