<?php

namespace App\Http\Controllers;

use App\Model\Locales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocalesController extends Controller
{
    public $locale;
    public function __construct(Locales $locales)
    {
        $this->locale =$locales;
    }

    public function getLocale()
    {
        // get all locales
    }

    public function getLocales()
    {
        $shops = \ShopifyApp::shop();
        $shops->api()->setVersion('unstable');

        $data=$shops->api()->graph('{
                                  shopLocales {
                                    locale
                                    primary
                                    published
                                  }
                                }')->body->shopLocales;
        foreach($data as $value)
        {
            $locale = $value->locale;
            $primary = $value->primary;
            $published = $value->published;
            $this->locale->saveDatalocale($locale, $primary , $published );
        }
        return redirect()->intended('locale/');
    }

    public function viewCreateLocale(){
        $locales = new Locales();

        $shops = \ShopifyApp::shop();
        $shops->api()->setVersion('unstable');
        $data = $shops->api()->graph('{
                              availableLocales {
                                isoCode
                                name
                              }
                            }')->body->availableLocales;
        return view('locale.createLocale',[
            'data'=>$data
        ]);
    }

    public function postLocale(Request $request)
    {
        $locale = new Locales();
        $nameLocale = $request->txtNameLocale;
        $shops = \ShopifyApp::shop();
        $shops->api()->setVersion('unstable');
        $data = Locales::all();
        $query = 'mutation enableLocale($locale: String!) {
                                                                              shopLocaleEnable(locale: $locale) {
                                                                                userErrors {
                                                                                  message
                                                                                  field
                                                                                }
                                                                                shopLocale {
                                                                                  locale
                                                                                  name
                                                                                  primary
                                                                                  published
                                                                                }
                                                                              }
                                                                            }';
        $var = array("locale"=>$nameLocale);
        foreach($data as $key=>$value) {
            if ($value['locale_name'] == $nameLocale) {
//                return Redirect()::to('/')->with('mess', "Already Exist!");
                return Redirect::back()->withErrors(['Already Exist!', 'Already Exist!']);
            }
        }
        $shops->api()->graph($query, $var);

        $locale->locale_name = $nameLocale;
        $locale->published   = "0";
        $locale->primary     = "0";

        $locale->save();
        return redirect()->intended('locale/');
    }


    public function getPublishLocale(Request $request,$id){
        $locale = Locales::find($id);
        $query = 'mutation updateLocale($locale: String!, $published: ShopLocaleInput!) {
                                  shopLocaleUpdate(locale: $locale, shopLocale: $published) {
                                    userErrors {
                                      message
                                      field
                                    }
                                    shopLocale {
                                      name
                                      locale
                                      primary
                                      published
                                    }
                                  }
                                }';
        $var = array("locale"=>$locale['locale_name'],"published"=>["published"=>true]);
        $shop = \ShopifyApp::shop();
        $shop->api()->setVersion('unstable');
        $data = $shop->api()->graph($query,$var);
        $locale->published=1;
        $locale->save();
        return redirect()->intended('locale/');
    }

    public function getRemoveLocale($id){
        $locales = Locales::all();
        $shop = \ShopifyApp::shop();
        $shop->api()->setVersion('unstable');
        $data = 'mutation updateLocale($locale: String!, $published: ShopLocaleInput!) {
                                  shopLocaleUpdate(locale: $locale, shopLocale: $published) {
                                    userErrors {
                                      message
                                      field
                                    }
                                    shopLocale {
                                      name
                                      locale
                                      primary
                                      published
                                    }
                                  }
                                }';
        $var =  array("locale"=>'en',"published"=>["published"=>true]);
        $shop->api()->graph($data,$var);
        Locales::destroy($id);
        return back();
    }
}
