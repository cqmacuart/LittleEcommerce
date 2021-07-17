<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    //
    public function order()
    {
        $this->belongsTo('App\Order');
    }
    public function product()
    {
        $this->belongsTo('App\Product');
    }
}
