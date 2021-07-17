<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tupa extends Model
{
    //
    public function pagos(){
        return $this->belongsTo(Pago::class)->withTimesTamps();
    }
}
