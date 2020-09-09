<?php

use App\Negocio;
use App\Perfil;
use App\User;

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

// Route::get('/crear_perfiles', function(){
// 	$perfil = new Perfil;
// 	$perfil->perfil = 'AdminSitio';
// 	$perfil->save();

// 	$perfil = new Perfil;
// 	$perfil->perfil = 'AdminNegocio';
// 	$perfil->save();

// });


// Route::get('/crear_usuario_admin', function(){
// 	$usuario = new User;
// 	$usuario->name = 'Roque Gómez';
// 	$usuario->email = 'gomezroque@hotmail.com';
// 	$usuario->password =  bcrypt('Chimango0720');
// 	$usuario->perfil_id = 1;
// 	$usuario->save();

// });



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => 'auth'], function(){

	Route::get('/redirigir',function(){
		// $negocio = Negocio::where('user_id',Auth()->user()->id)->get();
		// // $negocio = Negocio::find(Auth()->user()->negocio_id);
		// return $negocio;
	    return redirect()->route('negocio');
	});



	Route::get('negocio','Negocio\NegocioController@index')->name('negocio');
	Route::get('negocio/editar','Negocio\NegocioController@edit')->name('negocio.editar');
	Route::put('negocio/guardar/','Negocio\NegocioController@update')->name('negocio.guardar');

	Route::get('categorias', 'Categoria\CategoriaController@index')->name('categorias.index');
	Route::get('categorias/buscar', 'Categoria\CategoriaController@categorias_buscar')->name('categorias.buscar');
	Route::get('categorias/categorias_buscar_autocompletar', 'Categoria\CategoriaController@categorias_buscar_autocompletar')->name('categorias.buscar.autocompletar');
	Route::post('categorias/accion', 'Categoria\CategoriaController@categorias_accion')->name('categorias.accion');

	Route::get('caracteristicas', 'Caracteristica\CaracteristicaController@index')->name('caracteristicas.index');
	Route::get('caracteristicas/buscar', 'Caracteristica\CaracteristicaController@caracteristicas_buscar')->name('caracteristicas.buscar');
	Route::get('caracteristicas/caracteristicas_buscar_autocompletar', 'Caracteristica\CaracteristicaController@caracteristicas_buscar_autocompletar')->name('caracteristicas.buscar.autocompletar');
	Route::post('caracteristicas/accion', 'Caracteristica\CaracteristicaController@caracteristicas_accion')->name('caracteristicas.accion');

	Route::get('productos','Producto\ProductoController@index')->name('productos.index');
	Route::get('albumes','Producto\ProductoController@albumes')->name('productos.albumes');
	Route::get('productos/{tipo_id}/buscar', 'Producto\ProductoController@productos_buscar')->name('productos.buscar');
	Route::get('productos/productos_buscar_autocompletar', 'Producto\ProductoController@productos_buscar_autocompletar')->name('productos.buscar.autocompletar');

	Route::get('productos/create/{tipo_id?}','Producto\ProductoController@create')->name('productos.create');
	Route::get('productos/edit/{codigo}','Producto\ProductoController@edit')->name('productos.edit');
	Route::get('producto/{id}/productos_relacionados', 'Producto\ProductoController@buscar_productos_relacionados')->name('productos.relacionados');
	Route::post('producto/producto_relacionar','Producto\ProductoController@producto_relacionar')->name('productos.relacionar');
	Route::get('producto/producto_relacionado_eliminar/','Producto\ProductoController@producto_relacionado_eliminar')->name('productos.relacionado_eliminar');
	Route::post('productos/accion', 'Producto\ProductoController@productos_accion')->name('productos.accion');
	Route::get('productos/{id}/eliminar', 'Producto\ProductoController@producto_eliminar')->name('producto.eliminar');
	Route::get('producto/categorias', 'Producto\ProductoController@producto_categorias')->name('producto.categorias');
	Route::get('producto/caracteristicas', 'Producto\ProductoController@producto_caracteristicas')->name('producto.caracteristicas');
	Route::get('producto/caracteristicas_activas', 'Producto\ProductoController@producto_caracteristicas_activas')->name('producto.caracteristicas_activas');
	Route::post('producto/agregar_caracteristicas', 'Producto\ProductoController@producto_agregar_caracteristica')->name('producto.agregar_caracteristicas');

	Route::get('producto/categorias_activas', 'Producto\ProductoController@producto_categorias_activas')->name('producto.categorias_activas');
	Route::post('producto/agregar_categorias', 'Producto\ProductoController@producto_agregar_categoria')->name('producto.agregar_categorias');

	Route::get('producto/{codigo_id}/imagenes', 'Producto\ProductoController@producto_obtener_imagenes')->name('producto.obtener_imagenes');
	Route::get('producto/{imagen_id}/imagenes/borrar', 'Producto\ProductoController@producto_borrar_imagenes')->name('producto.borrar_imagenes');
	Route::post('producto/guardar', 'Producto\ProductoController@producto_guardar')->name('producto.guardar');
	Route::post('producto/imagenes/guardar', 'Producto\ProductoController@producto_imagenes_guardar')->name('producto.imagenes_guardar');


	Route::post('formSubmit','ImageController@formSubmit');
	Route::post('store-multiple-image','ImageController@store');


});

Route::get('/{url_negocio}','Negocio\NegocioController@public_index');