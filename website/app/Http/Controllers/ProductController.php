<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Products_Group;

class ProductController extends Controller
{
    function index($id)
    {
        $products_group = Products_Group::where('id',$id)->first();
        $groups_array = array();
        $groups_array = $this->find_groups($products_group, $groups_array);

        $products = Products::whereIn('group_id',$groups_array)->where('is_active',1)->get();

        return view('products.index',['products'=>$products]);
    }

    function find_groups($group, $groups_array)
    {
        if($group->Products_Group->count() != 0)
        {
            foreach($group->Products_Group as $child_group)
            {
                $groups_array = $this->find_groups($child_group, $groups_array);
            }
        }
        $groups_array[$group->id] = $group->id;
        return $groups_array;
    }

    function details($groupname, $id)
    {
        $product = Products::where('id',$id)->first();
        return view('products.details',['product'=>$product]);
    }
}
