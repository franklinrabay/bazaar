<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function artisan()
    {
        return $this->belongsTo(Artisan::class, 'artisan_id');
    }

    public function sells()
    {
        return $this->belongsToMany('App\Sell');
    }
}
