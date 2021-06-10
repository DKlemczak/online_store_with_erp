<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Order;
use App\Models\ProductsTags;
use App\Models\Product_To_Tags;
use App\Models\Products_Group;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $table = $request->json()->all();

        $orders = Order::where('status', 1)->get();

        if ($orders->count() != 0)
        {
            return response(['message' => 'Wszystkie zamówienia muszą zostać zsynchronizowane przed synchronizacją produktów.'], 403);
        }
        else
        {
            foreach ($table as $product_details)
            {
                $product_check = Products::where('uuid', $product_details['uuid'])->first();
                if(isset($product_check))
                {
                    $product = $product_check;
                }
                else
                {
                    $product = new Products;
                }

                $product->name = $product_details['name'];
                $product->uuid = $product_details['uuid'];
                $product->code = $product_details['code'];
                $product->amount = $product_details['amount'];
                $product->price = $product_details['price'];
                $product->description = $product_details['description'];
                $product->is_active = $product_details['is_active'];
                $group = Products_Group::where('name', $product_details['group_name'])->first();
                $product->group_id = $group->id;
                $product->discount = $product_details['discount'];

                foreach($product_details['tags'] as $tag)
                {
                    $product_tag = ProductsTags::where('name',$tag['name'])->first();
                    if(!isset($product_tag))
                    {
                        $product_tag = new ProductsTags;
                        $product_tag->name = $tag['name'];
                        $product_tag->save();
                    }
                    $product_to_tag = Product_To_Tags::where(['products_id'=>$product->id, 'products_tags_id'=>$product_tag->id])->first();
                    if(!isset($product_to_tag))
                    {
                        $product_to_tag = new Product_To_Tags;
                        $product_to_tag->products_id = $product->id;
                        $product_to_tag->products_tags_id = $product_tag->id;
                        $product_to_tag->save();
                    }
                }
                $product->save();
            }
        }
    }
}
