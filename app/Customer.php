<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    //
    protected $fillable = [
        "order_pedido",
        "nombre",
        "ciudad",
        "direccion",
        "celular",
        "email",
        "comentario",
        "notificacion",
    ];

    public function order()
    {
        $this->belongsTo('App\Order');
    }
}
