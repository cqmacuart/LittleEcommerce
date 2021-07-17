<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'hBgColor',
        'hTxColor',
        'hScColor',
        'hTrColor',
        'nvBgColor',
        'nvTxColor',
        'nvBrColor',
        'fBgColor',
        'fTxColor',
        'sbBgColor',
        'sbIcColor',
        'sbScColor',
        'sbTxColor',
        'hmBgColor',
        'hmTxColor',
        'ctBgColor',
        'ctTxColor',
        'pPrColor',
        'pIcColor',
        'hideLogo',
    ];
}
