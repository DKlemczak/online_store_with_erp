<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport_Type extends Model
{
    public $timestamps = false;
    protected $table = 'transport_type';

    public function Order()
    {
        return $this->belongsTo(Payment_Type::class);
    }
}
