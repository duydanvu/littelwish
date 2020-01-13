<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable = [
        'id',
        'title',
        'handle',
        'description',
        'locales',
        'shop_id'
    ];
}
