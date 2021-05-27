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
            $productgroup_check = ProductsGroup::where('name', $enova_group['name'])->first();
            if(isset($productgroup))
            {
                $productgroup = $productgroup_check;
            }
            else
            {
                $productgroup = new Products_Group;
            }
            $productgroup->on_navber = $enova_group['on_navber'];
            $productgroupname_check = ProductsGroup::where('name',$enova_group['group_name'])->first();
            $productgroup->group_id = $productgroupname_check->id;
            $productgroup->save();
        }
    }
}
