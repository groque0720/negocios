<?php

namespace App\Http\Controllers\RedSocial;

use App\Http\Controllers\Controller;
use App\Negocio;
use Illuminate\Http\Request;

class RedSocialController extends Controller
{
    public function redes_sociales_negocio(Request $request, $url_negocio){
        $negocio = Negocio::where('url',$url_negocio)->first();
        $redes_sociales = $negocio->redes_sociales()->get();
        return $redes_sociales;
    }
}
