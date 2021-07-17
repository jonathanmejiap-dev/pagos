<?php

namespace App\Http\Controllers\Admin;

use App\Pago;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{

    public function index(Request $request)
    {
        $pagos = Pago::where('estado', '0')
                        ->orderBy('updated_at','desc')
                        ->get();

        // dd($expedientes);

        return view('admin.pagos.index', compact('pagos'));
    }

    public function index_confirmados(Request $request)
    {
        $pagos = Pago::where('estado', '1')
                        ->orderBy('updated_at','desc')
                        ->get();


        // dd($expedientes);

        return view('admin.pagos.confirmado', compact('pagos'));
    }

    public function index_rechazados(Request $request)
    {
        $pagos = Pago::where('estado', '2')
                        ->orderBy('updated_at','desc')
                        ->get();


        // dd($expedientes);

        return view('admin.pagos.rechazado', compact('pagos'));
    }

    public function index_bajas(Request $request)
    {
        $pagos = Pago::where('estado', '3')
                        ->orderBy('updated_at','desc')
                        ->get();


        // dd($expedientes);

        return view('admin.pagos.baja', compact('pagos'));
    }

    //
    public function contador_nuevo_pago(Request $request)
    {

        // dd($request->all());
        if ($request->ajax()) {
            $pagos = Pago::where('estado', '0')->get();
            // dd($pagos);
            $contador_nuevos = count($pagos);
            // dd($contador_nuevos);
            return json_decode($contador_nuevos);
        } //procesa la peticion ajax 
        else {
        } //retornas por ejemplo,una vistadd($request->all());
    }

    public function confirmar(Pago $pag)
    {
        // dd($exp->id);
        $pag->estado = '1'; //CODIGO 1 ACEPTADO
        $pag->mensaje = "Pago validado correctamente";
        $pag->update();

        Session::flash('estado', 'aceptado');
        return redirect()->route('admin.pagos.index');
    }

    public function rechazar(Pago $pag, Request $request)
    {

        // dd($exp->id);
        $pag->estado = '2'; //CODIGO 3 RECHAZADO
        $pag->mensaje = $request->get('mensaje');
        $pag->update();

        Session::flash('estado', 'rechazado');
        return redirect()->route('admin.pagos.index');

        //buscamos los expedientes y los listamos
        //$expedientes = Expediente::where('estado', '0')->get();
        //dd($expedientes);


    }

    public function actualizar(Pago $pag, Request $request)
    {

        // dd($exp->id);
        $pag->estado = $request->get('estado'); //CODIGO 3 RECHAZADO
        $pag->mensaje = $request->get('mensaje');
        $pag->update();

        if($request->get('estado') == 3 ){
            Session::flash('estado', 'baja');
            return redirect()->route('admin.pagos.index_confirmados');
        }

        if($request->get('estado') == 1 ){
            Session::flash('estado', 'aceptado');
            return redirect()->route('admin.pagos.index_confirmados');
        }

        

        //buscamos los expedientes y los listamos
        //$expedientes = Expediente::where('estado', '0')->get();
        //dd($expedientes);


    }

    public function graficos(Request $request){

        // dd($request->all());
        if ($request->ajax()) {
            $pagos = DB::table('pagos')
                 ->select(DB::raw('sum(monto) as Total, estado as Estado'))
                 ->groupBy('estado')
                 ->whereMonth('created_at','=',date('m'))
                 ->get();
                 

            //$pagos = Pago::whereMonth('created_at','=',date('m'))->where('estado','=','1')->get();
            // dd($pagos);
            // $contador_nuevos = count($expedientes);
            // dd($contador_nuevos);
            return json_encode($pagos);
        } //procesa la peticion ajax 
        else {
        } //retornas por ejemplo,una vistadd($request->all());
    }

    public function destroy(Pago $pag)
    {
        //dd(count($tipo_documento->expedientes));

        $pag->delete();

        Session::flash('estado', 'borrado');
        return redirect()
            ->route('admin.pagos.index');
    }
}
