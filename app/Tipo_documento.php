<?php

namespace App;
use App\Expediente;

use Illuminate\Database\Eloquent\Model;

class Tipo_documento extends Model
{
    public function expedientes(){
        return $this->hasMany(Expediente::class);
    }
}
