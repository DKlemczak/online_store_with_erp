<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';

    public function Positions()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
