<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $fillable = [
        'id_blogs',
        'title',
        'description',
        'author',
        'handle',
        'image',
        'parent_id',
        'locales',
        'shop_id'
    ];

}
