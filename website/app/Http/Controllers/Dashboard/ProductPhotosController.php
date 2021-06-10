<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Models\Product_Photos;
use File;

class ProductPhotosController extends Controller
{
    function index($id)
    {
        $photos = Product_Photos::where('product_id',$id)->get();
        return view('dashboard.products.photos.index',['photos' => $photos,'product_id' => $id]);
    }

    function create($product_id)
    {
        return view('dashboard.products.photos.create',['product_id' => $product_id]);
    }

    function store(Request $request, $product_id)
    {
        $path = public_path().'/img/product_photos/';

        if(!File::exists($path))
        {
            File::makeDirectory($path);
        }
        $path = public_path().'/img/product_photos/'.$product_id;
        if(!File::exists($path))
        {
            File::makeDirectory($path);
        }

        $Image = $request->file;

        $Image->move($path.'/', $filename = 'img_'.Str::random(15).'.jpg');

        $photo = new Product_Photos();
        $photo->no = $request->no;
        $photo->product_id = $product_id;
        $photo->path = '/img/product_photos/'.$product_id.'/'.$filename;
        $photo->save();

        return redirect()->route('dashboard.products.photos.index',[$product_id]);
    }

    function destroy(Request $request,$product_id,$id)
    {
        $photo = Product_Photos::where('id',$id)->first();

        $photo->delete();

        return redirect()->route('dashboard.products.photos.index',[$product_id]);
    }
}
