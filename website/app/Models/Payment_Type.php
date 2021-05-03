<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Type extends Model
{
    public $timestamps = false;
    protected $table = 'payment_type';

    public function Order()
    {
        return $this->belongsTo(Payment_Type::class);
    }
}
