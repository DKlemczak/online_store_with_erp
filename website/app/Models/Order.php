<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';

    public function Positions()
    {
        return $this->hasMany(Order_Positions::class);
    }

    public function Payment()
    {
        return $this->hasOne(Payment_Type::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Transport()
    {
        return $this->hasOne(Transport_Type::class);
    }
}
