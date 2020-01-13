<?php

namespace App\Http\Controllers;

use App\BlogParents;
use App\Blogs;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    // get information blogs
    public function getBlogs(){
        $shop = \ShopifyApp::shop();
        $blogs = $shop->api()->rest('GET','/admin/api/2019-10/articles.json');

        $getAllBlogs = $blogs->body->articles;
        foreach ($getAllBlogs as $item){
            $item = get_object_vars($item);
            $image = $item['image'];
            $image = get_object_vars($image);
            if (isset($image['src'])){
                $blogs = new Blogs([
                    'id_blogs'=> $item['id'],
                    'title'=> $item['title'],
                    'handle' => $item['handle'],
                    'author' => $item['author'],
                    'description' => $item['body_html'],
                    'image' => explode('?',$image['src'])[0],
                    'parent_id' => $item['blog_id'],
                    'locales'=>"en",
                    'shop_id'=>$shop->id
                ]);
                $blogs->save();
            }

        }
    }

    public function getDataBlogsParent(){
        $shop = \ShopifyApp::shop();
        $blog = $shop->api()->rest('GET','/admin/api/2019-10/blogs.json');

        $getAllblogs = $blog->body->blogs;
        foreach ($getAllblogs as $item){
            $item = get_object_vars($item);
            $blogs = new BlogParents([
                'blogs_id'=> $item['id'],
                'title'=> $item['title'],
                'handle' => $item['handle'],
                'shop_id'=>$shop->id
            ]);
            $blogs->save();
        }
    }

}
