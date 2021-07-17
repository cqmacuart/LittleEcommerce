<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =
    [
        "nombre",
        "position",
        "estado_id",
        "tipo_id",
        "parent_id",
        "descripcion",
        "image"
    ];
    //
    public function estado()
    {
        return $this->belongsTo("App\Estado");
    }

    public function tipo()
    {
        return $this->belongsTo("App\Tipo");
    }
}
