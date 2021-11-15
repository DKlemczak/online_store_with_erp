<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public $timestamps = false;
    protected $table = 'comments';

    public function posts()
    {
        return $this->belongsTo('App\Models\Posts');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}