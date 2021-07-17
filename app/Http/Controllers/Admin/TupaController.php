<?php

namespace App\Http\Controllers\Admin;

use App\Tupa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TupaController extends Controller
{
    public function index(){
        $tupas = Tupa::where('estado', '1')
        ->orderBy('nombre', 'asc')
        ->get();
        return view('admin.tupas.index', compact('tupas'));
    }

    public function store(Request $request)
    {
       
        $this->validate($request, [
            'nombre' => 'required|min:3',
            'monto' => "required",
        ]);
        

        // dd($request->all());
        $tupa = new Tupa;
        $tupa->nombre = Str::title($request->get('nombre'));
        $tupa->monto = $request->get('monto');
        $tupa->estado =  '1'; //1 = activo, 0= inactivo
        $tupa->save();

        Session::flash('estado', 'registrado');
        return redirect()
                        ->route('admin.tupas.index');

    }

    public function destroy(Tupa $tup)
    {
        //dd(count($tipo_documento->expedientes));
        
            $tup->delete();
            Session::flash('estado', 'ok');

        return redirect()
            ->route('admin.tupas.index');
    }
}
