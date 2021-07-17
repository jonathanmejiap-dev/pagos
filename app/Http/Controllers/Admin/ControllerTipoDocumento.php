<?php

namespace App\Http\Controllers\Admin;

use App\Tipo_documento;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ControllerTipoDocumento extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tipo_documentos = Tipo_documento::all();
        return view('admin.tipodocumento.index', compact('tipo_documentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tipodocumento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nombre' => 'required|min:3|unique:tipo_documentos',
           
        ]);

        // dd($request->all());
        $tipodoc = new Tipo_documento;
        $tipodoc->nombre = Str::title($request->get('nombre'));
        $tipodoc->save();

        Session::flash('estado', 'registrado');
        return redirect()
                        ->route('admin.tipodocumento.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipo_documento  $tipo_documento
     * @return \Illuminate\Http\Response
     */
    public function show(Tipo_documento $tipo_documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipo_documento  $tipo_documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipo_documento $tipo_documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipo_documento  $tipo_documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tipo_documento $tipo_documento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipo_documento  $tipo_documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tipo_documento $tipo_documento)
    {
        //dd(count($tipo_documento->expedientes));
        if(count($tipo_documento->expedientes) == 0){
            $tipo_documento->delete();
            Session::flash('estado', 'ok');
            
        }else{
            Session::flash('estado', 'error');
        }
            
        return redirect()
        ->route('admin.tipodocumento.index')
        ->with('flash', 'La publicación ha sido eliminada.');
        
        
    }
}
