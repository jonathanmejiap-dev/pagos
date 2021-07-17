<?php

namespace App\Http\Controllers\Admin;

use App\{Expediente,Seguimiento, Area, Movimiento};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class ControllerExpediente extends Controller
{
    //
    public function index(Request $request)
    {
        //evaluamos que tenga datos
        $estado = "1";
        if (count($request->all()) != 0) {
            switch ($request->get('tipo')) {
                case "1":
                    $estado = "1";
                    break;
                case "2":
                    $estado = "2";
                    break;
                case "3":
                    $estado = "3";
                    break;
                case "4":
                    $estado = "4";
                    break;
                case "5":
                    $estado = "5";
                    break;
                default:
                    $estado = "1";
                    break;
            }
        }
        Session::flash('codigo', $estado);
        

        $expedientes = Expediente::where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $areas = Area::skip(1)->take(4)->get();
        $movimientos = Movimiento::skip(3)->take(5)->get();
        
        // dd($expedientes);

        return view('admin.tramites.index', compact('expedientes', 'areas', 'movimientos'));
    }

    //aceptaqdos
    public function index_aceptados(Request $request, $estado)
    {
        switch ($estado) {
            case 1:
                $expedientes = Expediente::where('estado', '1')->get();
                break;
            case 2:
                $expedientes = Expediente::where('estado', '2')->get();
                break;
            case 3:
                $expedientes = Expediente::where('estado', '3')->get();
                break;
            case 4:
                $expedientes = Expediente::where('estado', '4')->get();
                break;
            case 5:
                $expedientes = Expediente::where('estado', '5')->get();
                break;
            default:
                $expedientes = Expediente::where('estado', '1')->get();
                break;
        }
        //dd($request->all());

        // dd($expedientes);
        return view('admin.tramites.index', compact('expedientes'));
    }

    public function aceptar(Expediente $exp)
    {
        // dd($exp->id);
        $exp->estado = '2'; //CODIGO 2 ACEPTADO

        $exp->update();
        $seg = new Seguimiento();
        $seg->fecha = date("Y-m-d");
        $seg->ver = "eliminar";
        $seg->acciones = "Documento aceptado";
        $seg->expediente_id = $exp->id;
        $seg->area_id = 2;
        $seg->movimiento_id =  2; //ACEPTADO
        $seg->user_id = Auth::user()->id;
        $seg->save();

        Session::flash('estado', 'aceptado');
        return redirect()->route('admin.tramites');



        //buscamos los expedientes y los listamos
        // $expedientes = Expediente::where('estado', '0')->get();
        //dd($expedientes);


    }

    public function rechazar(Expediente $exp, Request $request)
    {
        
        // dd($exp->id);
        $exp->estado = '3'; //CODIGO 3 RECHAZADO

        $exp->update();

        $seg = new Seguimiento();
        $seg->fecha = date("Y-m-d");
        $seg->ver = "eliminar";
        $seg->acciones = $request->get('mensaje');
        $seg->expediente_id = $exp->id;
        $seg->area_id = 2;
        $seg->movimiento_id =  3; //ACEPTADO
        $seg->user_id = Auth::user()->id;
        $seg->save();

        Session::flash('estado', 'rechazado');
        return redirect()->route('admin.tramites');



        //buscamos los expedientes y los listamos
        // $expedientes = Expediente::where('estado', '0')->get();
        //dd($expedientes);


    }

    public function aceptar_ajax(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $expediente = Expediente::findOrFail($request->get("codigo"));

            $expediente->estado = '1';
            $expediente->save();
        } //procesa la peticion ajax 
        else {
        } //retornas por ejemplo,una vistadd($request->all());
    }

    public function contador_nuevo_tramite(Request $request)
    {

        // dd($request->all());
        if ($request->ajax()) {
            $expedientes = Expediente::where('estado', '1')->get();
            // dd($expedientes);
            $contador_nuevos = count($expedientes);
            // dd($contador_nuevos);
            return json_decode($contador_nuevos);
        } //procesa la peticion ajax 
        else {
        } //retornas por ejemplo,una vistadd($request->all());
    }

    public function ver_detalles(Request $request)
    {

        $expediente = Expediente::findOrFail($request->get('codigo'));
        //con esta intruccion obtenemos el nombre gracias a la relación en el objeto EXPEDIENTES
        $expediente['nombre_tipo'] = $expediente->tipo_documento->nombre;
        $expediente['nombre_navegante'] = $expediente->navegante->nombres;

        return $expediente;
    }
}
