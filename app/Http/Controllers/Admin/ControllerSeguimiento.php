<?php

namespace App\Http\Controllers\Admin;

use App\{Expediente, Seguimiento};

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControllerSeguimiento extends Controller
{
    //
    public function store(Expediente $exp, Request $request){
        // dd(Auth::user()->id);
        // dd($request->all());
        //dd($exp);

        // $this->validate($request, [
        //     'area' => 'required',
        //     'movimiento' => 'required',
        //     'mensaje' => 'required|min:5',
        // ]);

        $seg = new Seguimiento();
        $seg->fecha = date('Y-m-d');
        $seg->ver = "vacio";
        $seg->acciones = $request->get('mensaje'); 
        $seg->expediente_id = $exp->id; 
        $seg->area_id = $request->get('area');
        $seg->movimiento_id = $request->get('movimiento');
        $seg->user_id = Auth::user()->id;
        $seg->save();

        $exp->estado = $seg->movimiento_id;
        $exp->save();
      

        Session::flash('codigo', $exp->estado);
        return redirect()->route('admin.tramites');

        

    }
}
