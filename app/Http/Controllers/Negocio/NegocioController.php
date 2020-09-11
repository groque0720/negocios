<?php

namespace App\Http\Controllers\Negocio;

use App\Http\Controllers\Controller;
use App\Negocio;
use App\Producto;
use App\ProductoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NegocioController extends Controller
{
    protected $cant_reg = 10;

    public function public_index($url_negocio){
        if ($negocio = Negocio::where('url', $url_negocio)->first()) {
            return view('public.index', compact('negocio'));
        }else{
            return 'no se encuentra..';
        }
    }

    public function buscar_imagenes_random(Request $request, $url_negocio){
        if ($request->ajax()) {






            if ($negocio = Negocio::where('url', $url_negocio)->first()) {
                $imagenes = ProductoImagen::select('productos_imagenes.*')
                                            ->join('productos', 'productos.id', '=', 'productos_imagenes.producto_id')
                                            ->where('productos.negocio_id','=', $negocio->id)
                                            //->orderBy(DB::raw('RAND(1234)'))
                                            ->inRandomOrder('1234')
                                            ->paginate($this->cant_reg);
                return $imagenes;
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        return view('negocio.index', compact('negocio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        return view('negocio.editar', compact('negocio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if ($request->email) {
            $this->validate($request,[
                'email' => 'email'
            ]);
        }

        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();

        $negocio->email = $request->email;
        $negocio->telefono = $request->telefono;
        $negocio->celular = $request->celular;
        $negocio->direccion = $request->direccion;

        if ($request->hasFile('logo')) {
            if ($negocio->logo != 'public/logo_default_negocio.png') {
                Storage::delete($negocio->logo);
            }
            $logo = $request->file('logo')->store('public/'.$negocio->url);
            $negocio->logo = $logo;
        }
        $negocio->save();

        return $negocio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
