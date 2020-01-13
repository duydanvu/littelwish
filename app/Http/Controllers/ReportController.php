<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use OhMyBrew\ShopifyApp\ShopifyApp;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var ShopifyApp
     */
    protected $shop;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function createsAssets($folderName,$fileName,$Delete = true){
        $shop = \ShopifyApp::shop();

        //upload the metafield to assets
        $AssetApi = [ "key" => "assets/".$fileName, "src" => "http://ibigecommerce.com/shopify/".$fileName];
        $allAssets = $shop->api()->rest('PUT', '/admin/api/2019-10/themes/74304454730/assets.json',["asset"=>$AssetApi]);

        //Duplicate metafield
        $AssetMetafield = [ "key" => $folderName."/".$fileName, "source_key" => "assets/".$fileName];
        $allAssets = $shop->api()->rest('PUT', '/admin/api/2019-10/themes/74304454730/assets.json',["asset"=>$AssetMetafield]);

        //Delete The metafield assets
        if($Delete) $shop->api()->rest('DELETE', '/admin/api/2019-10/themes/74304454730/assets.json?asset[key]=assets/'.$fileName);

    }

    public function getDashboard()
    {
        $shop = \ShopifyApp::shop();
        $configModel = $this->config;

        /*
         * Creates an asset for a theme.
         */
        //1.file assets/smart-search.scss.liquid
        $this->createsAssets('assets','smart-search.scss.liquid',false);


        $dataSearchQueries = DB::table('report_dashboard')
            ->select('phrase','result',DB::raw('count(phrase) as total'))
            ->where('shop_id', $shop->id)
            ->where('result', '=','yes')
            ->groupBy('phrase','result')
            ->orderBy('total', 'DESC')

            ->get();

        $dataSearchNoResult = DB::table('report_dashboard')
            ->select('phrase','result',DB::raw('count(phrase) as total'))
            ->where('shop_id', $shop->id)
            ->where('result', '=','no')
            ->groupBy('phrase','result')
            ->orderBy('total', 'DESC')

            ->get();

        return view('report')->with(['dataSearchQueries'=>$dataSearchQueries,'dataSearchNoResult'=>$dataSearchNoResult]);;


    }

    /**
     * add request for table report_dashboard
     * @param Request $request
     * @return json
     */
    public function addPhrase(Request $request)
    {

        $domain = $request->get('domain');
        $dataPhrase = $request->get('phrase');
        $dataResults = $request->get('results');
        $shopModel = config('shopify-app.shop_model');
        $shop = $shopModel::withTrashed()->firstOrCreate(['shopify_domain' => $domain]);

        $insertData = [];
        $currentDate = Carbon::now()->toDateString();

        array_push($insertData,['phrase'=>$dataPhrase,'result'=>$dataResults,'shop_id'=>$shop->id,'created_at'=>$currentDate]);

        DB::table('report_dashboard')->insert($insertData);

        return ['insertData'=>$insertData];
    }

}
