<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use OhMyBrew\ShopifyApp\ShopifyApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    const CONFIG_NAME = [
        'general_suggestion_status'=>'general_suggestion_status',
        'general_categories_status'=>'general_categories_status',
        'general_articles_status'=>'general_articles_status',
        'general_suggestion_price'=>'general_suggestion_price',
        'general_suggestion_derc'=>'general_suggestion_derc',

        'general_product_price'=>'general_product_price',
        'general_product_reviews'=>'general_product_reviews',
        'general_product_derc'=>'general_product_derc',
        'general_product_per'=>'general_product_per',
        'general_product_title'=>'general_product_title',
        'general_product_button'=>'general_product_button',
        'general_product_vendor'=>'general_product_vendor',

    ];

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var ShopifyApp
     */
    protected $shop;

    public function __construct(Config $config,ShopifyApp $shop)
    {
        $this->config = $config;
        $this->shop = $shop;
    }

    public function index()
    {
        $shop = $this->shop->shop();

        $configModel = $this->config;
        $configData = [];
        // foreach loop configdata
        foreach (self::CONFIG_NAME as $value){
            $configValues = $configModel->where(['name'=>$value,'shop_id'=>$shop->id])->first()->value ?? '';
            $configData[$value]=$configValues;
        }

        $json_configData =json_encode($configData);
        $shopAPI = \ShopifyApp::shop();
        $metafield = ["namespace" => "inventory", "key" => "warehouse", "value" => $json_configData, "value_type"=> "json_string"];
        $shopAPI->api()->rest('POST','/admin/api/2019-10/metafields.json',["metafield"=>$metafield]);

        return view('indexSetting')->with(['data'=>$configData]);
    }

    /**
     * save form search setting
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function save(Request $request)
    {
        $shop = $this->shop->shop();
        $configModel = $this->config;

        foreach (self::CONFIG_NAME as $value){
            $dataModel = $configModel->where(['name'=>$value,'shop_id'=>$shop->id])->first() ?? new Config;
            $dataFill = $request->input($value) ?? '';

            $dataModel->fill(['name'=>$value,'shop_id'=>$shop->id,'value'=>$dataFill])->save();
        }
        return back()->with('status','Your settings have been successfully saved');
    }


}
