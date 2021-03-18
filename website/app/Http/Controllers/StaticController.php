<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    function index()
    {
        return view('statics.index');
    }
}
