<?php

use App\Helpers\Helper;
use App\Negocio;
use App\Perfil;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


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


// Route::get('/crear_carpeta', function(){
// 	mkdir("storage/"."omar", 0700);
// });

        // Authentication Routes...
		Route::get('/login/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::get('acceder', 'Auth\LoginController@showLoginForm')->name('acceder');
        Route::post('acceder', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::post('/token_validacion', function(Request $request){
	return Helper::validar_recaptcha($request->letras, $request->token);
});

Route::get('/token_validacion', function(){
	return Helper::obtener_recaptcha();
});

Route::group(['domain' => '{account}.vidriera.online'], function () {

    Route::get('/', function ($account) {
    	$url_negocio = $account;
        return redirect()->route('/', compact('url_negocio'));
    });

    Route::get('/','Negocio\NegocioController@public_index');
	Route::get('/buscar_imagenes_random/{producto_id?}','Negocio\NegocioController@buscar_imagenes_random');
	Route::get('/buscar_albumes','Negocio\NegocioController@buscar_albumes');
	Route::get('/producto/{codigo}/{imagen_id?}','Negocio\NegocioController@mostrar_producto');
	Route::get('/album/{codigo}/{imagen_id?}','Negocio\NegocioController@mostrar_producto');
	Route::get('/productos/mismas_categorias/','Negocio\NegocioController@mostrar_productos_mismas_categorias');
	Route::get('/productos/categoria/{categoria}/','Negocio\NegocioController@mostrar_productos_categoria');

});

Route::get('/home', function () {
	if (auth()->check()) {
		return redirect()->route('redirigir');
	}else{
		return redirect()->route('acceder');
	}
})->name('home');

Route::get('/', function () {
	if (auth()->check()) {
		return redirect()->route('redirigir');
	}else{
		return redirect()->route('acceder');
	}
});

Route::group(['middleware' => 'auth'], function(){

	Route::get('/redirigir',function(){
	    return redirect()->route('negocio');
	})->name('redirigir');

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


	Route::get('/precio_lista', 'ListaPrecio\ListaPrecioController@index')->name('lista_precio.index');
	Route::get('/precio_lista/editar_precio', 'ListaPrecio\ListaPrecioController@editar_precio')->name('lista_precio.editar_precio');
	Route::get('/precio_lista/correccion_precio', 'ListaPrecio\ListaPrecioController@correccion_precio')->name('lista_precio.correccion_precio');

});


Route::get('/{url_negocio}','Negocio\NegocioController@public_index')->name('url_negocio.index');
Route::get('/{url_negocio}/search','Negocio\NegocioController@public_index');
Route::get('/{url_negocio}/redes_sociales','RedSocial\RedSocialController@redes_sociales_negocio');
Route::get('/{url_negocio}/items_de_busqueda','Negocio\NegocioController@items_de_busqueda');
Route::get('/{url_negocio}/buscar_imagenes_random/{producto_id?}','Negocio\NegocioController@buscar_imagenes_random');
Route::get('/{url_negocio}/buscar_albumes','Negocio\NegocioController@buscar_albumes');
Route::get('/{url_negocio}/producto/{codigo}/{imagen_id?}','Negocio\NegocioController@mostrar_producto');
Route::get('/{url_negocio}/album/{codigo}/{imagen_id?}','Negocio\NegocioController@mostrar_producto');
Route::get('/{url_negocio}/productos/mismas_categorias/','Negocio\NegocioController@mostrar_productos_mismas_categorias');
Route::get('/{url_negocio}/productos/categorias/filtro/{categoria?}','Negocio\NegocioController@productos_categoria_filtro');
Route::get('/{url_negocio}/productos/albumes_mismas_categorias/','Negocio\NegocioController@mostrar_albumes_mismas_categorias');

