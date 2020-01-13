<?php


namespace App\Http\Controllers;


use App\Collection;
use App\Product;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class SearchController extends Controller
{
    public  function search(Request $request){
        $keyword = $request->get('phrase');
        $local = $request->get('locales');
        $domain = $request->get('domain');
        $shopModel = config('shopify-app.shop_model');
        $shop = $shopModel::withTrashed()->firstOrCreate(['shopify_domain' => $domain]);
        $productSuggestions = $this->searchProduct($keyword,$local,$shop->id);
        $pageSuggesttions = $this->searchPages($keyword,$local,$shop->id);
        $blogSuggesttions = $this->searchBlog($keyword,$local,$shop->id);

        return response()->json(['success' => true,'productSuggestions' => $productSuggestions,'pageSuggestions' => $pageSuggesttions,
            'blogSuggesttion' => $blogSuggesttions]);
    }

    public function getSearchFormData(Request $request){

        $domain = $request->get('domain');
        $term = $request->get('term');
        $shopModel = config('shopify-app.shop_model');
        $shop = $shopModel::withTrashed()->firstOrCreate(['shopify_domain' => $domain]);

        $productSuggestions = $this->getSuggestions($shop);
        return response()->json(['success' => true,'productSuggestions' => $productSuggestions]);
    }


    public function getCollectionFormData(Request $request ){

        $domain = $request->get('domain');
        $shopModel = config('shopify-app.shop_model');
        $shop = $shopModel::withTrashed()->firstOrCreate(['shopify_domain' => $domain]);
        $local = $request->get('locales');
        $dataSearchQueries = Collection::select('collection_id','title','handle','description','image','locales')
            ->where('locales',$local)
            ->where('shop_id',$shop->id)
            ->get();
        return response()->json(['success' =>true,'productCollections'=>$dataSearchQueries]);
    }


    // show the phrase popular
    public function getSuggestions($shop){
        $dataSearchQueries = DB::table('report_dashboard')
            ->select('phrase')
            ->where('shop_id', $shop->id)
            ->where('result', 'yes')
            ->groupBy('phrase')
            ->get();
        return $dataSearchQueries;
    }

    public function  searchPages($keyword , $local,$shopID ){
        $dataSearchQueries = DB :: table('pages')
            ->select('title','handle','description','shop_id','locales')
            ->where('locales',$local)
            ->where('shop_id',$shopID)
            ->where(function ($query) use ($keyword){
                $query  ->where('title','like','%'.$keyword.'%')
                    ->orwhere('description','like','%'.$keyword.'%');
            })->get();
        return $dataSearchQueries;
    }

    public function  searchBlog($keyword , $local ,$shopID ){
        $dataSearchQueries = DB :: table('blogs')
            ->select('blogs.title','blogs.handle','description','blogs.shop_id','locales','author','image','blog_parents.handle as parenttitle')
            ->join('blog_parents','blog_parents.blogs_id','=','blogs.parent_id')
            ->where('locales',$local)
            ->where('blogs.shop_id',$shopID)
            ->where(function ($query) use ($keyword){
                $query  ->where('blogs.title','like','%'.$keyword.'%')
                    ->orwhere('description','like','%'.$keyword.'%')
                    ->orwhere('author','like','%'.$keyword.'%');
            })->get();
        return $dataSearchQueries;
    }

    public function searchProduct($keyword, $local,$shopId){
        $dataSearchQueries = DB::table('products')
            ->select('products.product_id','title','handle','description','image','locales',
                \DB::raw("MAX(variants.price) AS max_price"),
                \DB::raw("MIN(variants.price) AS min_price"))
            ->join('variants','variants.product_id','=','products.product_id')
            ->where('locales',$local)
            ->where('products.shop_id',$shopId)
            ->where(function ($query) use ($keyword){
                $query  ->where('title','like','%'.$keyword.'%')
                    ->orwhere('description','like','%'.$keyword.'%');
            })->groupBy('product_id')
            ->groupBy('title','handle','image','description','locales')
            ->get();
        return $dataSearchQueries;
    }
}
