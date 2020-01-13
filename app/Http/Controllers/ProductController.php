<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Product;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
//    public function testMetafield(){
//        $shop = \ShopifyApp::shop();
//        $products = $shop->api()->rest('GET','/admin/api/2019-10/products.json');
//    }

    public function getProducts(){
        $shop = \ShopifyApp::shop();
        $products = $shop->api()->rest('GET','/admin/api/2019-10/products.json');

        $getAllProducts = $products->body->products;
        foreach ($getAllProducts as $item){
                $item = get_object_vars($item);
                $image = $item['image'];
                $image = get_object_vars($image);
                if (isset($image['src'])){
                    $product = new Product([
                        'product_id'=> $item['id'],
                        'title'=> $item['title'],
                        'handle' => $item['handle'],
                        'description' => $item['body_html'],
                        'image' => explode('?',$image['src'])[0],
                        'locales'=>"en",
                        'shop_id'=>$shop->id
                    ]);
                    $product->save();
                }

        }
    }

    public function refreshData(){
        $shop = \ShopifyApp::shop();
        $refreshProduct = DB::table('products')
                    ->where('shop_id',$shop->id)
                    ->where('locales','=','en')
                    ->delete();
        $this->getProducts();
        $refreshVariant = DB::table('variants')
                            ->where('shop_id',$shop->id)
                            ->delete();
        $productapi = $shop->api()->rest('GET','/admin/api/2019-10/products.json');

        $getAllProducts = $productapi->body->products;

        foreach ($getAllProducts as $item){
            $item = get_object_vars($item);
            $variants = $item['variants'];
            foreach ($variants as $var){
                $var = get_object_vars($var);
                $variant = new Variant([
                    'id'=>$var['id'],
                    'product_id'=>$var['product_id'],
                    'variants_title'=>$var['title'],
                    'shop_id'=>$shop->id,
                    'price'=>$var['price']
                ]);
                $variant->save();
            }

        }
        $products = Product::all()->where('shop_id','=',$shop->id);
        return view('list',compact('products'));
    }

    public function getlist(){
        $shop = \ShopifyApp::shop();
        $products = Product::all()->where('shop_id','=',$shop->id);
        if(sizeof($products) == 0){
            $this->getProducts();
            $variant = Variant::all()->where('shop_id','=',$shop->id);
            if(sizeof($variant) == 0){
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
                            'shop_id'=>$shop->id,
                            'price'=>$var['price']
                        ]);
                        $variant->save();
                    }

                }
            }
            $products = Product::all()->where('shop_id','=',$shop->id);
            return view('list',compact('products'));
        }else{
            return view('list',compact('products'));
        }
    }

    public function getListProductWithID($id){
        $products = Product::where('product_id',$id)->get();
        return view('listProductDetail',compact('products'));
    }

    public function postUpdate(Request $request,$id){
        $shop = \ShopifyApp::shop();
        $product = Product::find($id);
        $locales = $request->get('product_locales');

        $request->validate([
            'product_title'=>'required',
            'inputDescription'=> 'required',
            'product_locales' => 'required'
        ]);
        $productlocales = Product::where('locales',$locales)
                        ->where('product_id',$product->product_id)
                        ->where('shop_id',$shop->id)
                        ->get();
        if(sizeof($productlocales) == 0 && $request->get('product_locales') != "") {
            $newProduct = new Product([
                'product_id' => $product->product_id,
                'title' => $request->get('product_title'),
                'handle' => $product->handle,
                'description' => $request->get('inputDescription'),
                'image' => $product->image,
                'locales' => $request->get('product_locales'),
                'shop_id' => $shop->id
            ]);
            $newProduct->save();
            var_dump($newProduct);
            return redirect('product/getdetail/'.$product->product_id)->with('success', 'Add successfully');
        }else{
            return redirect('product/getview/'.$id)->with('status','Add not success');
        }
    }

    public function getedit($id){
        $product = Product::find($id);
        return view('add',compact('product'));
    }

    public function getInforProductWithLocales($id, $locales){
        $product = Product::select('title','description')
            ->where('locales',$locales)
            ->where('product_id',$id)
            ->get();
        return view('add',compact('product'));
    }

    public function getReport(){
        $dataSearchNoResult = DB::table('reports')
            ->select('phrase','result',DB::raw('count(phrase) as total'))
            ->where('result', ' ')
            ->groupBy('phrase')
            ->orderBy('total', 'DESC')
            ->get();
    }

    public function getDataAjax(Request $request){
        $locale = $request->get('locale');
        $id = $request->get('id');
        $dataproduct = Product::select('title','description')
            ->where('locales',$locale)
            ->where('product_id',$id)
            ->get();
        return $dataproduct;
    }

}
