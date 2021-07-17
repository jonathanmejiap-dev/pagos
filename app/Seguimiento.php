<?php

namespace App;

use App\{Area, Movimiento};
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function movimiento(){
        return $this->belongsTo(Movimiento::class);
    }
}
