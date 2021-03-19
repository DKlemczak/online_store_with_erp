<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Products_Group;

class ProductController extends Controller
{
    function index($id)
    {
        $product_groups = Products_Group::where('id',$id)->first();

        if($product_groups->Products_Group->count() != 0)
        {
            $groups_array = array();
            $counter = 0;
            foreach($product_groups->Products_Group as $Product_group)
            {
                $groups_array[$counter] = $Product_group->id;
                $counter++;
            }
            $products = Products::whereIn('group_id',$groups_array)->get();
        }
        else
        {
            $products = Products::where('group_id',$id)->where('is_active',1)->get();
        }
        return view('products.index',['products'=>$products]);
    }

    function details($group_id, $id)
    {
        $products = Products::where('id',$id)->get();
        return view('products.details');
    }
}
