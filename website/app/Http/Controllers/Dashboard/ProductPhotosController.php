<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_Photos;

class ProductPhotosController extends Controller
{
    function index($id)
    {
        $photos = Product_Photos::where('product_id',$id)->get();
        return view('dashboard.products.photos.index',['photos' => $photos]);
    }

    function destroy(Request $request,$id)
    {
        $photo = Product_Photos::where('id',$id)->first();
        $product_id = $photo->product_id;
        $photo->delete();

        $photos = Product_Photos::where('product_id',$product_id)->get();
        return redirect()->route('dashboard.products.photos.index',[$product_id]);
    }
}
