<?php

namespace App\Console\Commands;

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Product;
use App\Variant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class everyFiveMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update database Product and Collection';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // update information Product,Variant and Collections
        $shop = \OhMyBrew\ShopifyApp\ShopifyApp::shop();

        // delete old database
        $refreshProduct = DB::table('products')
            ->where('shop_id',$shop->id)
            ->where('locales','=','en')
            ->delete();

        $refreshVariant = DB::table('variants')
            ->where('shop_id',$shop->id)
            ->delete();

        $refreshCollection = DB::table('collections')
            ->where('shop_id',$shop->id)
            ->where('locales','=','en')
            ->delete();

        $product = new ProductController();
        $product->getProducts();

        $variant = new VariantController();
        $variant->getVariants();

        $collection = new CollectionController();
        $collection->getCollections();

    }
}
