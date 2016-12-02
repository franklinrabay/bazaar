<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $table = 'sells';
    
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('amount', 'value');
    }
}
