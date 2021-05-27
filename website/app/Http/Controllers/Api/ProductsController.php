<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Order;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->json()->all();

        $orders = Order::with('positions')->where('status', 2)->get();
        if ($orders)
        {
            return response(['message' => 'Wszystkie zamówienia muszą zostać zsynchronizowane przed synchronizacją produktów.'], 403);
        }
    }
}
