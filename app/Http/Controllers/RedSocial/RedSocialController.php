<?php

namespace App\Http\Controllers\RedSocial;

use App\Http\Controllers\Controller;
use App\Negocio;
use App\NegocioRedSocial;
use App\RedSocial;
use Illuminate\Http\Request;

class RedSocialController extends Controller
{
    public function redes_sociales_negocio(Request $request, $url_negocio){
        $negocio = Negocio::where('url',$url_negocio)->first();
        $redes_sociales = $negocio->redes_sociales()->get();
        return $redes_sociales;
    }

    public function redes_sociales(Request $request){
    	$redes_sociales = RedSocial::orderBy('red_social')->get();
    	return $redes_sociales;
    }

    public function index (Request $request){
    	$negocio = Negocio::where('user_id',Auth()->user()->id)->first();
    	$redes_sociales = RedSocial::orderBy('red_social')->get();
    	$redes_sociales_negocio = $negocio->redes_sociales()->get();
    	return view('redes_sociales.index', compact('negocio','redes_sociales','redes_sociales_negocio'));
    }

    public function guardar(Request $request) {

    	$negocio = Negocio::where('user_id',Auth()->user()->id)->first();
    	$redes =  $request->redes;

    	NegocioRedSocial::where('negocio_id',$negocio->id)->delete();

    	foreach ($redes as $red) {
    		if ($red['pivot']['url'] != '') {
				try {
		    		$negocio_red_social = new NegocioRedSocial();
		    		$negocio_red_social->negocio_id = $negocio->id;
		    		$negocio_red_social->red_social_id = $red['id'];
		    		$negocio_red_social->url = $red['pivot']['url'];
		    		$negocio_red_social->save();
	    		} catch (Exception $e ) {
					return 'error';
			    }
    		}
    	}

    	return 'ok';

    }

}
