<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    //
    public function navegante(){
        return $this->belongsTo(Navegante::class);
    }

    public function tipo_documento(){
        return $this->belongsTo(Tipo_documento::class);
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }
}
