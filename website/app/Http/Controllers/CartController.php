<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use StaticController;
use App\Models\Products;
use App\Models\Order;
use App\Models\Order_Positions;
use App\Models\Payment_Type;
use App\Models\Transport_Type;
use App\Models\User;
use Illuminate\Support\Str;

class CartController extends Controller
{
    function index()
    {
        $cart = session()->get('cart');
        $value = 0;
        $Payment_Type = Payment_Type::get();
        $Transport_Type = Transport_Type::get();
        foreach($cart as $product)
        {
            $value += $product['price'] * $product['amount'];
        }
        return view('cart.index',['cart' => $cart,'value' => $value, 'payments' => $Payment_Type, 'transports' => $Transport_Type]);
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
                    'uuid' => $product->uuid,
                    'price' => $product->price - $product->price * ($product->discount * 0.01)
                ]
            ];
        }
        else
        {
            $key = 0;
            foreach($cart as $cartprod)
            {
                if($cartprod['id'] == $product->id)
                {
                    $cartprod['amount'] = $cartprod['amount'] + $request->amount;
                    $cart[$key] = $cartprod;

                    session()->put('cart', $cart);
                    return redirect()->back();
                }
                $key++;
            }
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
            return redirect('/');
        }

        session()->put('cart', $cart);

        return redirect('/cart');
    }

    public function destroytheCart()
    {
        session()->forget('cart');
    }
    public function summary(Request $request)
    {
        $cart = session()->get('cart');

        $value = 0;

        foreach($cart as $product)
        {
            $value += $product['price'] * $product['amount'];
        }
        $transport = Transport_Type::Where('id',$request->transport)->first();
        $payment = Payment_Type::Where('id',$request->payment)->first();
        $ordernumber = Order::orderby('id','desc')->first();

        if($ordernumber == null)
        {
            $number = 1;
        }
        else
        {
            $number = $ordernumber->id + 1;
        }

        $value = $value + $payment->price + $transport->price;

        $order = new Order();
        $order->uuid = Str::uuid();
        $order->user_name = $request->name;
        $order->user_surname = $request->surname;
        $order->document_number = "zam/".$number;
        $order->city = $request->city;
        $order->post_code = $request->post_code;
        $order->street = $request->street;
        $order->building_number = $request->building_number;
        $order->email = $request->email;
        $order->phone_number = $request->phone_number;
        $order->value = $value;
        $order->transport_id = $transport->id;
        $order->payment_id = $payment->id;
        if(auth::user() != null)
        {
            $order->user_id = auth::user()->id;
        }
        $order->status = 0;
        session()->put('order', $order);
        return view("cart.summary",['cart' => $cart, 'order' => $order, 'transport'=> $transport, 'payment' => $payment]);
    }

    public function createorder()
    {
        $cart = session()->get('cart');
        $order = session()->get('order');
        $order->status = 1;
        $order->save();
        foreach($cart as $product)
        {
            $position = new Order_Positions();
            $position->amount = $product['amount'];
            $position->price = $product['price'];
            $position->product_id = $product['id'];
            $position->product_uuid = $product['uuid'];
            $position->order_id = $order->id;
            $position->save();

            $DBProduct = Products::where('id',$product['id'])->first();
            $DBProduct->amount = $DBProduct->amount - $product['amount'];
            $DBProduct->save();
        }
        session()->forget('cart');
        session()->forget('order');
        return redirect('/');
    }
}
