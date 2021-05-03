<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class StaticController extends Controller
{
    function index()
    {
        $products = Products::where('discount','>',0)->orderByDesc('discount')->take(4)->get();
        return view('statics.index',['products' => $products]);
    }
}
