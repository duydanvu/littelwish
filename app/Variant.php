<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'variants_title',
        'shop_id',
        'price'
    ];
}
