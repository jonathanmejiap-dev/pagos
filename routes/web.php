<?php

use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Gate;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('controlpago.index');
Route::get('/', 'PagesController@index')->name('controlpago.index');

/*****************CONTROL DE PAGOS**************** */
Route::post('/registro/pago', 'PagoController@store')->name('pago.store');
Route::post('/consulta/pago', 'PagoController@consulta')->name('pago.consulta_ajax');



Route::post('proceso', 'PagesController@proceso')->name('proceso.index');

//Route::post('proceso/siguelo','PagesController@proceso_consulta')->name('proceso.consulta');
Route::get('proceso/tramite-nuevo/{dni}', 'PagesController@proceso_tramiteNuevo')->name('proceso.tramiteNuevo');
Route::get('proceso/tramite-existente2', 'PagesController@proceso_tramiteExistente')->name('proceso.tramiteExistente');

Route::post('proceso/registrar', 'PagesController@proceso_registrar_nuevo')->name('proceso.registrar.nuevo');
Route::post('proceso/registrar/tramite', 'PagesController@proceso_registrar_existente')->name('proceso.registrar.existente');

//Rutas roles
Route::resource('/role', 'RoleController')->names('role');

Route::get('/test', function () {
    //return User::get();

    $user = User::find(2);
    //Gate::authorize('haveaccess', 'role.show');
    return $user;

    //$user->roles()->sync([2]); //id del rol en la tabla
    //return $user->roles;
    //return $user->havePermission('role.index');

});

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => 'auth'
    ],
    function () {

        //ADMINISTRACIÓN
        Route::resource('/user', 'UserController', [
            'except' => [
                'create',
                'store'
            ]
        ])->names('user');

        Route::get('/home', 'HomeController@index')->name('home');

        Route::get('/pagos', 'PagoController@index')->name('admin.pagos.index');//usado
        Route::get('/pagos/confirmados', 'PagoController@index_confirmados')->name('admin.pagos.index_confirmados');//usado
        Route::get('/pagos/rechazados', 'PagoController@index_rechazados')->name('admin.pagos.index_rechazados');//usado
        Route::get('/pagos/bajas', 'PagoController@index_bajas')->name('admin.pagos.index_bajas');//usado
        Route::get('/tramites/{estado}', 'ControllerExpediente@index_aceptados')->name('admin.tramites.index_aceptados');
        Route::get('/admin/pagos/{pag}/aceptar', 'PagoController@confirmar')->name('admin.pago.confirmar');//usado
        Route::post('/admin/pagos/{pag}/rechazar', 'PagoController@rechazar')->name('admin.pago.rechazar');//usado
        Route::post('/admin/pagos/{pag}/actualizar', 'PagoController@actualizar')->name('admin.pago.actualizar');//usado
        Route::delete('/admin/pagos/{pag}', 'PagoController@destroy')->name('admin.pago.destroy');//usado
        Route::post('/pagos/graficos', 'PagoController@graficos')->name('admin.pago.graficos');//usado


        Route::post('/admin/{exp}/seguimiento/store', 'ControllerSeguimiento@store')->name('admin.seguimiento.store');
        //
        //ruta ajax
        Route::post('/tramites_aceptar', 'ControllerExpediente@aceptar_ajax')->name('admin.tramites.aceptar_ajax');
        Route::get('/pagos/contador/nuevos/elementos', 'PagoController@contador_nuevo_pago')->name('admin.pagos.contador_ajax'); //usado
        Route::post('/tramites/ver/detalles', 'ControllerExpediente@ver_detalles')->name('admin.tramites.ver_detalles');

        Route::get('/tupas', 'TupaController@index')->name('admin.tupas.index');//usado
        Route::get('/tipodocumento/crear', 'ControllerTipoDocumento@create')->name('admin.tipodocumento.create');
        Route::post('/tupas/store', 'TupaController@store')->name('admin.tupas.store');//usado
        Route::post('/tipodocumento/store', 'ControllerTipoDocumento@store')->name('admin.tipodocumento.store');//usado
        Route::delete('/tupas/{tup}', 'TupaController@destroy')->name('admin.tupas.destroy');
    }
);

Auth::routes(['register' => false]);


