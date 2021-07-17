<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        "storename",
        "mobile",
        "city",
        "country",
        "location",
        "email",
        "image",
        "favicon",
        "currency",
        "code"
    ];
}
