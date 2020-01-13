<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'title',
        'handle',
        'description',
        'image',
        'locales',
        'shop_id'
    ];
}
