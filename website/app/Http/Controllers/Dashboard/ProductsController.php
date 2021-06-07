<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    function index()
    {
        $products = Products::get();
        return view('dashboard.products.index',['products' => $products]);
    }
}
