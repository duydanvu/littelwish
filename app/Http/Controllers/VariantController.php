<?php

namespace App\Http\Controllers;

use App\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    function getVariants(){
        $shop = \ShopifyApp::shop();
        $products = $shop->api()->rest('GET','/admin/api/2019-10/products.json');

        $getAllProducts = $products->body->products;

        foreach ($getAllProducts as $item){
            $item = get_object_vars($item);
            $variants = $item['variants'];
            foreach ($variants as $var){
                $var = get_object_vars($var);
                $variant = new Variant([
                    'id'=>$var['id'],
                    'product_id'=>$var['product_id'],
                    'variants_title'=>$var['title'],
                    'price'=>$var['price']
                ]);
                $variant->save();
            }

        }
    }

    function getlistvariant($idProduct){
        $variants = Variant::where('product_id',$idProduct)->get();
        return view('listvariant',compact('variants'));
    }
}
