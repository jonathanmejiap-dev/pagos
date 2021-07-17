<?php

namespace App\Http\Controllers;

use App\{Navegante, Pago};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PagoController extends Controller
{
    //
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'dni' => 'required|min:8',
            'nombres' => 'required|min:8',
            'telefono' => 'required|min:9',
            'tramite' => 'required',
            'operacion' => 'required|min:6|unique:pagos,num_op',
            'monto' => 'required|min:2',
            'archivo' => 'required',
            'check_ok' => 'required',

        ]);

        //validamos el archivo
     

        if ($request->file('archivo')) {
            /* subimos la imagen original*/ 
            $archivo = $request->file('archivo')->store('public/voucher');
            $archivoUrl = Storage::url($archivo);
            // $filename = $file->getClientOriginalName();
            // $foo = \File::extension($filename);
            
            //     $route_file = $code . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
            //     Storage::disk('public')->put($route_file, \File::get($file));
                // Storage::disk('public')->put($route_file,\File::get($file));
        }else{
            $archivoUrl='vacio';
        }
        // dd($request->get('dni'));
        $registros = Navegante::find($request->get('dni'));
        
        if ($registros == null) {
          
            //registrar el usuario
            $nav = new Navegante;
            $nav->id = $request->get('dni');
            $nav->nombres = $request->get('nombres');
            $nav->telefono = $request->get('telefono');
            $nav->email = $request->get('email') != null ? $request->get('email') : "Sin email";
            $nav->estado = '1';
            $nav->save();
        } else {

           
            $registros->nombres = $request->get('nombres');
            $registros->telefono = $request->get('telefono');
            $registros->email = $request->get('email') != null ? $request->get('email') : "Sin email";
            $registros->save();
        }

        $pago = new Pago;
        $pago->num_op = $request->get('operacion');
        $pago->monto = $request->get('monto');
        $pago->estado = '0';
        $pago->mensaje = 'Enviado para revisión y confirmación';
        $pago->tupa_id = $request->get('tramite');
        $pago->navegante_id = $request->get('dni');
        $pago->archivo = $archivoUrl;
        $pago->save();

        
        Session::flash('estado', 'registro_ok');
        return redirect()->route('controlpago.index');


    }

    public function consulta(Request $request){

        if ($request->ajax()) {
            $pago = Pago::where('num_op',$request->get('codigo'))->first();
            // json_decode();
          return ($pago);
        }
    }
}
