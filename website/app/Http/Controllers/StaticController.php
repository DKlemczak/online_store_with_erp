<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Staticsites;

class StaticController extends Controller
{
    function index()
    {
        $Staticsites = Staticsites::where('name', 'Strona główna')->first();
        $products = Products::where('discount','>',0)->orderByDesc('discount')->take(4)->get();
        return view('statics.index',['products' => $products, 'Staticsites' => $Staticsites]);
    }
}
