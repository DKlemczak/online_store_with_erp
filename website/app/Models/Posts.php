<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    public $timestamps = false;
    protected $table = 'posts';

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}