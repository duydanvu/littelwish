<?php

namespace App\Http\Controllers;

use App\Pages;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getDataPages(){
        $shop = \ShopifyApp::shop();
        $pages = $shop->api()->rest('GET','/admin/api/2019-10/pages.json');

        $getAllPages = $pages->body->pages;
        foreach ($getAllPages as $item){
            $item = get_object_vars($item);
            $pages = new Pages([
                'id'=> $item['id'],
                'title'=> $item['title'],
                'handle' => $item['handle'],
                'description' => $item['body_html'],
                'locales'=>"en",
                'shop_id'=>$shop->id
            ]);
            $pages->save();
        }
    }
}
