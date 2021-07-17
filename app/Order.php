<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "pedido",
        "customer_id",
        "orderstate_id",
        "amount",
        "link",
        "transaccion",
        "serialize",
    ];
    //
    public function customer()
    {
        $this->belongsTo('App\Customer');
    }

    public function orderstate()
    {
        return $this->belongsTo("App\OrderState");
    }
}
