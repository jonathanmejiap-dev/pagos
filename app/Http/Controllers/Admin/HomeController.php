<?php

namespace App\Http\Controllers\Admin;

use App\Expediente;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::user()->role);
        // $expedientes = Expediente::where('estado', '0')->get();
        // dd($expedientes);
        return view('home');
    }
}
