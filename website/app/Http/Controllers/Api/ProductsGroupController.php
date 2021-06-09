<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products_Group;

class ProductsGroupController extends Controller
{
    function index(Request $request)
    {
        $table = $request->json()->all();

        foreach ($table as $enova_group)
        {
            $productgroup_check = Products_Group::where('name', $enova_group['name'])->first();
            if(isset($productgroup_check))
            {
                $productgroup = $productgroup_check;
            }
            else
            {
                $productgroup = new Products_Group;
            }

            $productgroup->name = $enova_group['name'];
            $productgroup->on_navbar = $enova_group['on_navbar'];

            $productgroupname_check = Products_Group::where('name',$enova_group['parent_group_name'])->first();
            if(is_null($productgroupname_check))
            {
                $productgroup->group_id = null;
            }
            else
            {
                $productgroup->group_id = $productgroupname_check->id;
            }

            $productgroup->save();
        }
    }
}
