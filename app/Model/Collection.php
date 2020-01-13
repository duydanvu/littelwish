<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = [
      'id',
      'collection_id',
      'title',
      'handle',
      'description',
      'image',
      'locales',
        'shop_id'
    ];
}
