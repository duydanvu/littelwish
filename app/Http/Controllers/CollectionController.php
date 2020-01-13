<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    //
    public function getCollections(){
        $shop = \ShopifyApp::shop();
        $collections = $shop->api()->rest('GET','/admin/api/2019-10/smart_collections.json');
        $getAllCollections = $collections->body->smart_collections;

        foreach ($getAllCollections as $item){
            $item = get_object_vars($item);
            $image = $item['image'];
            $image = get_object_vars($image);
            if (isset($image['src'])){
                $collection = new Collection([
                    'collection_id'=> $item['id'],
                    'title'=> $item['title'],
                    'handle' => $item['handle'],
                    'description' => $item['body_html'],
                    'image' => explode('?',$image['src'])[0],
                    'locales'=>"en",
                    'shop_id'=>$shop->id
                ]);
                $collection->save();
            }

        }
    }

    public function refreshData(){
        $shop = \ShopifyApp::shop();
        $refreshProduct = DB::table('collections')
            ->where('shop_id',$shop->id)
            ->where('locales','=','en')
            ->delete();
        $this->getCollections();
        $collections = Collection::all()->where('shop_id','=',$shop->id);
        return view('listCollection',compact('collections'));
    }

    public function getListCollections(){
        $shop = \ShopifyApp::shop();
        $collections = Collection::all()->where('shop_id','=',$shop->id);
        if(sizeof($collections) == 0){
            $this->getCollections();
            $collections = Collection::all()->where('shop_id','=',$shop->id);
            return view('listCollection',compact('collections'));
        }
        return view('listCollection',compact('collections'));
    }

    public function getListCollectionWithID($id){
        $collections = Collection::where('collection_id',$id)->get();
        return view('listCollectionDetail',compact('collections'));
    }

    public function getCollectionEdit($id){
        $collection = Collection::find($id);
        return view('addCollection',compact('collection'));
    }

    public function postNewLocales(Request $request,$id){
        $shop = \ShopifyApp::shop();
        $collection = Collection::find($id);
        $locales = $request->get('collection_locales');

        $request->validate([
            'collection_title'=>'required',
            'collection_handle'=> 'required',
            'collection_description'=>'required',
        ]);
        $collectionlocales = Collection::where('locales',$locales)
                            ->where('collection_id',$collection->collection_id)
                            ->where('shop_id',$shop->id)
                            ->get();
        if(sizeof($collectionlocales) == 0 && $request->get('collection_locales') != "") {
            $newCollection = new Collection([
                'collection_id' => $collection->collection_id,
                'title' => $request->get('collection_title'),
                'handle' => $collection->handle,
                'description' => $request->get('collection_description'),
                'image' => $collection->image,
                'locales' => $request->get('collection_locales'),
                'shop_id' => $shop->id
            ]);
            $newCollection->save();
            return redirect('collection/getdetail/'.$collection->collection_id)->with('success', 'Add successfully');
        }else{
            return redirect('collection/getview/'.$id)->with('status','Add not success');
        }
    }

    public function getDataAjax(Request $request){
        $locale = $request->get('locale');
        $id = $request->get('id');
        $datacollection = Collection::select('title','description')
            ->where('locales',$locale)
            ->where('collection_id',$id)
            ->get();
        return $datacollection;
    }
}
