<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "id_transaccion",
        "tipo",
        "status",
        "error",
        "respuesta_text",
        "customer_id",
        "customer_name",
        "cliente",
        "factura",
        "franquicia",
        "banco",
        "tarjeta",
        "moneda",
        "monto",
        "ip",
        "medio",
        "fecha_transaccion",
    ];
}
