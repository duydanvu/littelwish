<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Locales extends Model
{
    //
    protected $table = "locales";
    protected $guarded = [];
    public $timestamps = false;
    public  function saveDatalocale($locale, $primary , $published )
    {
        $locales = new Locales();

        $locales->locale_name = $locale;
        $locales->published = $published;
        $locales->primary = $primary;

        $locales->save();
        if($locales->save()){
            return true;
        }else {
            return false;
        }

    }
}
