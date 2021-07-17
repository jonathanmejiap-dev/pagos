<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    //

    public function tupa(){
        return $this->belongsTo(Tupa::class);
    }

    public function navegante(){
        return $this->belongsTo(Navegante::class);
    }
}
