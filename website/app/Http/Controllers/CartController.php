<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    function index()
    {
        return view('cart.index');
    }

    function addtocart(Request $request)
    {
        //Jeśli nie ma otwartej sesji z koszykiem, otworzyć nową, 
    }
}
