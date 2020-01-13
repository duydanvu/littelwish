<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogParents extends Model
{
    protected $fillable = [
        'blogs_id',
        'title',
        'handle',
        'shop_id'
    ];

}
