<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use StaticController;
use App\Models\Products;
use App\Models\Order;
use App\Models\Order_Positions;

class CartController extends Controller
{
    function index()
    {
        $cart = session()->get('cart');
        $value = 0;
        foreach($cart as $product)
        {
            $value += $product['price'];
        }

        return view('cart.index',['cart' => $cart,'value' => $value]);
    }

    function addtocart(Request $request)
    {
        $product = Products::where('id',$request->product_id)->first();
        $cart = session()->get('cart');

        if(!$cart)
        {
            $cart = [
                $product->id = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'amount' => $request->amount,
                    'price' => $product->price - $product->price * ($product->discount * 0.01)
                ]
            ];
        }
        else
        {
            foreach($cart as $cartprod)
            {
                if($cartprod['id'] == $product->id)
                {
                    $cartprod['amount'] = $cartprod['amount'] + $request->amount;
                    $cart[$product->id] = $cartprod;

                    session()->put('cart', $cart);
                    return redirect()->back();
                }
            }

            $cart[$product->id] =
            [
                'id' => $product->id,
                'name' => $product->name,
                'amount' => $request->amount,
                'price' => $product->price - $product->price * ($product->discount * 0.01)
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }

    function removefromcart($id)
    {
        $cart = session()->pull('cart', []);
        unset($cart[$id]);

        if(empty($cart))
        {
            CartController::destroytheCart();
            return view('statics.index');
        }

        session()->put('cart', $cart);

        $cart = session('cart');

        $value = 0;
        foreach($cart as $product)
        {
            $value += $product['price'];
        }

        return view("cart.index",['cart' => $cart, 'value' => $value]);
    }

    public function destroytheCart()
    {
        session()->forget('cart');
        return view('index');
    }
}
