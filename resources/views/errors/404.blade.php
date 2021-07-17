@extends('plantilla')
@section('titulo', '404 Pagina no encontrada')

@push('styles')
<link rel="stylesheet" href="{{asset('css/sb-admin-2.css')}}">


@endpush

@section('contenido')
    <div class="">
<!-- 404 Error Text -->
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Página no encontrada</p>
    <div class="border p-4">
        <p class="text-gray-600 mb-0">Parece que encontraste un error en la matriz...</p>
        <a href="{{url('/')}}">&larr; Volver al panel principal</a>
    </div>
    
</div>
    </div>
    @endsection

@push('scripts')
<link rel="stylesheet" href="{{asset('css/plantilla.css')}}">


@endpush