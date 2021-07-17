<?php

namespace App\Http\Controllers;

use App\{Tupa,Navegante};

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class PagesController extends Controller
{
    public function index(){
        $tupas = Tupa::where('estado','1')->get();
        // dd($tupas);
        return view('welcome', compact('tupas'));
    }
    
    public function proceso(Request $request)
    {
        $this->validate($request, [
            'dni' => 'required|min:8',
            'dni' => 'required',
        ]);
        //dd($request->all());
        $dni = $request->get("dni");
        $exp = $request->get("expediente");

        //Consultamos la existencia el usuario ingresado
        $navegante = Navegante::where('id', $request->get('dni'))->get();

        if ($request->get("opcion") == "consultar") {

            //Contrastamos los registros resultantes
            if ($navegante->count() != 0) {
                //obtenemos los expedientes del usuario
                $expedientes = Expediente::where('navegante_id', $request->get("dni"))
                                ->orderBy('updated_at','desc')
                                ->get();

                //redireccionamos a la alista de documentos

                return view('proceso.consulta', compact('navegante', 'expedientes'));
            } else {
                Session::flash('error', 'error');
                //return Redirect::to('admin/productos');
                return redirect()->route('mesa.home');
            }
        }
        if ($request->get("opcion") == "tramitar") {


            if ($navegante->count() != 0) {

                return view('proceso.tramiteExistente', compact("navegante"));
            } else {
                return redirect()->route('proceso.tramiteNuevo', $dni);
            }
        }
    }

    public function proceso_tramiteNuevo($dni)
    {

        $json = array();
        //$url = 'https://dniruc.apisperu.com/api/v1/dni/'.$request->get('dni').'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvbmF0aGFubWVqaWFwYWxhY2lvc0BnbWFpbC5jb20ifQ.kPsC8noMf-oa-4REqUpuzS3qI7P5DGMYJTUT-x-ZV4k';
        $url = 'https://dniruc.apisperu.com/api/v1/dni/' . $dni . '?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvbmF0aGFubWVqaWFwYWxhY2lvc0BnbWFpbC5jb20ifQ.kPsC8noMf-oa-4REqUpuzS3qI7P5DGMYJTUT-x-ZV4k';
        $json = file_get_contents($url);

        //lo convertimos para obtener la cantidad de elementos
        $final = json_decode($json, true);

        $navegante = json_decode($json);

        if (sizeof($final) > 3) {
            //
            return view("proceso.tramiteNuevo", compact('navegante'));
        } else {

            Session::flash('error', 'error');
            //return Redirect::to('admin/productos');
            return redirect()->route('mesa.home');
        }
    }
    public function proceso_tramiteExistente()
    {
        return view("proceso.tramiteExistente");
    }


    public function proceso_registrar_nuevo(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'dni' => 'required',
            'nombres' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'tipo_documento' => 'required',
            'asunto' => 'required',
            'folios' => 'required',
            'archivo' => 'mimes:pdf',           
        ]);

        $year = date('Y');
        // $code = 'DOC'.$year.'-'.str_pad($max_code->number_max +1, 7, "0", STR_PAD_LEFT);
        $code = 'tramites';

        $file = $request->file('archivo');

        // if($request->get('url') == null && $file == null){
        //     //Esto lo hacemos para validar los datos
        //     $navegante = Navegante::where('id', $request->get('dni'))->get();
        //     Session::flash('falta_archivo', 'falta_archivo');
        //     return view('proceso.tramiteNuevo', compact('navegante'));
        //     // return  back()->withInput();
        // }

        if($request->get('url') == null && $file == null){
            //Esto lo hacemos para validar los datos
            $navegante = Navegante::where('id', $request->get('dni'))->get();
            Session::flash('falta_archivo', 'falta_archivo');
            return view('proceso.tramiteExistente', compact('navegante'));
            // return  back()->withInput();
        }

        if ($file) {
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if ($foo == 'pdf') {
                $route_file = $code . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
                Storage::disk('public')->put($route_file, \File::get($file));
                // Storage::disk('public')->put($route_file,\File::get($file));

                // return response()->json([
                //     'response' => [
                //         'msg' => 'Registro Completado',
                //     ]
                // ], 201);
            } else {
                // return response()->json([
                //     'response' => [
                //         'msg' => 'Solo Archivos PDF',
                //     ]
                // ], 201);
            }
        }else{
            $route_file='';
        }

        $nav = new Navegante;
        $exp = new Expediente;

        $nav->id = $request->get('dni');
        $nav->nombres = $request->get('nombres');
        $nav->telefono = $request->get('telefono');
        $nav->email = $request->get('email');
        $nav->direccion = $request->get('direccion');
        $nav->save();

        //obtenemos el codigo
        $id = Expediente::all();
        $codigo = $id->count() + 1;

        if ($codigo <= 9) {
            $codigo = "00" . $codigo;
        } else {
            if ($codigo <= 99) {
                $codigo = "0" . $codigo;
            } else {
                if ($codigo <= 999) {
                    $codigo = $codigo;
                }
            }
        }

        $codigo = date("Y")  . $codigo;

        //dd($id->count());
        $exp->id = $codigo;
        $exp->asunto = $request->get('asunto');
        $exp->num_folios = $request->get('folios');
        $exp->tipo_documento_id = $request->get('tipo_documento');
        $exp->navegante_id = $request->get('dni');
        $exp->archivo = $route_file;
        $exp->url = $request->get('url');
        $exp->estado = 1;
        $exp->save();

        $segui = new Seguimiento;
        $segui->fecha = date('Y-m-d');
        $segui->ver = 'mensaje';
        $segui->acciones = 'Trámite enviado, a la espera para su aceptación o rechazo.';
        $segui->expediente_id = $codigo;
        $segui->area_id = 1;
        $segui->movimiento_id = 1;
        $segui->user_id = 1;
        $segui->save();

        Session::flash('estado', 'registro-ok');
        return redirect()->route('mesa.home');
    }

    public function proceso_registrar_existente(Request $request, Navegante $navegante)
    {
        //dd($request->all());
        $this->validate($request, [
            'dni' => 'required',
            'nombres' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'tipo_documento' => 'required',
            'asunto' => 'required',
            'folios' => 'required',
            'archivo' => 'mimes:pdf',           
        ]);
        

        // Thesis::select(
        //     DB::raw(' (IFNULL(MAX(RIGHT(thesis_code,7)),0)) AS number_max')
        // )->first();
        $year = date('Y');
        // $code = 'DOC'.$year.'-'.str_pad($max_code->number_max +1, 7, "0", STR_PAD_LEFT);
        $code = 'tramites';

        $file = $request->file('archivo');

        if($request->get('url') == null && $file == null){
            //Esto lo hacemos para validar los datos
            $navegante = Navegante::where('id', $request->get('dni'))->get();
            Session::flash('falta_archivo', 'falta_archivo');
            return view('proceso.tramiteExistente', compact('navegante'));
            // return  back()->withInput();
        }

        if ($file) {
            $filename = $file->getClientOriginalName();
            $foo = \File::extension($filename);
            if ($foo == 'pdf') {
                $route_file = $code . DIRECTORY_SEPARATOR . date('Ymdhmi') . '.' . $foo;
                Storage::disk('public')->put($route_file, \File::get($file));
                // Storage::disk('public')->put($route_file,\File::get($file));

                // return response()->json([
                //     'response' => [
                //         'msg' => 'Registro Completado',
                //     ]
                // ], 201);
            } else {
               
                // return response()->json([
                //     'response' => [
                //         'msg' => 'Solo Archivos PDF',
                //     ]
                // ], 201);
            }
        }else{
            $route_file ='vacio';
        }

        

        //termina las imagenes

        //guardamos el registro

        $nav = Navegante::find($request->get("dni"));

        $exp = new Expediente;
        $nav->nombres = $request->get('nombres');
        $nav->telefono = $request->get('telefono');
        $nav->email = $request->get('email');
        $nav->direccion = $request->get('direccion');
        $nav->update();

      



        //obtenemos el codigo
        $id = Expediente::all();
        $codigo = $id->count() + 1;

        if ($codigo <= 9) {
            $codigo = "00" . $codigo;
        } else {
            if ($codigo <= 99) {
                $codigo = "0" . $codigo;
            } else {
                if ($codigo <= 999) {
                    $codigo = $codigo;
                }
            }
        }

        $codigo = date("Y") . $codigo;

        //dd($id->count());
        $exp->id = $codigo;
        $exp->asunto = $request->get('asunto');
        $exp->num_folios = $request->get('folios');
        $exp->tipo_documento_id = $request->get('tipo_documento');
        $exp->navegante_id = $request->get('dni');
        $exp->archivo = $route_file;
        $exp->url = $request->get('url');
        $exp->estado = "1";
        $exp->save();

        $segui = new Seguimiento;
        $segui->fecha = date('Y-m-d');
        $segui->ver = 'mensaje';
        $segui->acciones = 'Trámite enviado, a la espera para su aceptación o rechazo.';
        $segui->expediente_id = $codigo;
        $segui->area_id = 1;
        $segui->movimiento_id = 1;
        $segui->user_id = 1;
        $segui->save();

        Session::flash('estado', 'registro-ok');
        return redirect()->route("mesa.home");
    }
}
