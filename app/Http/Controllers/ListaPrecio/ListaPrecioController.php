<?php

namespace App\Http\Controllers\ListaPrecio;

use App\Http\Controllers\Controller;
use App\Negocio;
use App\Producto;
use Illuminate\Http\Request;

class ListaPrecioController extends Controller
{
    public function index()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        return view('lista_precio.index', compact('negocio'));
    }

    public function editar_precio(Request $request){
    	//return $request->precio;
    	try {
	    	$producto = Producto::find($request->producto_id);
	    	$producto->precio = $request->precio;
	    	$producto->precio_obs = $request->precio_obs;
	    	$producto->save();
	    	return 'ok';
    	} catch (Exception $e ) {
    		return 'error';
    	}
    }

    public function correccion_precio(Request $request){

    	$correccion = $request->correccion;
    	$calculo = $request->calculo;
    	$valor = $request->valor;
    	$redondeo = $request->redondeo;

    	$negocio = Negocio::where('user_id',Auth()->user()->id)->first();
    	$productos = $negocio->productos()->where('tipo_id',1)->where('guardar',1)->get();

    	foreach ($productos as $producto) {

    		if ($producto->precio != 0) {

				$precio = $producto->precio;

				//pocentaje calculo = 1
	    		if ($calculo == 1) {
	    			$valor_a_modificar = ($valor * $precio) / 100;
	    		}else{
	    			$valor_a_modificar = $valor;
	    		}

	    		//aumento correeecion = 1
	    		if ($correccion == 1 ) {
	    			$precio = $precio + $valor_a_modificar;
	    		}else{
	    			$precio = $precio - $valor_a_modificar;
	    		}

	    		//redondear arriba - redondeo = 1
	    		if ($redondeo == 1) {
	    			$precio = ceil($precio);
	    		}

	    		//redondear abajo - redondeo = 2
	    		if ($redondeo == 2) {
	    			$precio = floor($precio);
	    		}

	       		$producto->precio = $precio;
	    		$producto->save();
	    	}
    	}

    	return 'ok';

    }
}
