<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        "country",
        "currency",
        "code",
        "symbol",
        "estado_id",
    ];
}
