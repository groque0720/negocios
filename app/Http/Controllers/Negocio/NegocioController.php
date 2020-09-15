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

    public function public_index(Request $request, $url_negocio){

            if ($request->session()->has('session_rand')) {
                if((time() - $request->session()->get('session_rand')) > 100){
                    $request->session()->put('session_rand', time());
                }
            }else{
                $request->session()->put('session_rand', time());
            }


            // dd($request->session()->get('session_rand'));


        if ($negocio = Negocio::where('url', $url_negocio)->first()) {
            return view('public.index', compact('negocio'));
        }else{
            return 'no se encuentra..';
        }
    }

    // Popurri
    public function buscar_imagenes_random(Request $request, $url_negocio){
        if ($request->ajax()) {
            if ($negocio = Negocio::where('url', $url_negocio)->first()) {
                $imagenes = ProductoImagen::select('productos_imagenes.*', 'productos.producto','productos.codigo AS producto_codigo')
                                            ->join('productos', 'productos.id', '=', 'productos_imagenes.producto_id')
                                            ->where('productos.negocio_id','=', $negocio->id)
                                            ->where('productos.guardar','=', 1)
                                            ->orderBy(DB::raw('RAND('.$request->session()->get('session_rand').')'))
                                            //->inRandomOrder($request->session()->get('session_rand'))
                                            ->paginate($this->cant_reg);
                return $imagenes;
            }
        }
    }
    // Albumes
    public function buscar_albumes(Request $request, $url_negocio){
        if ($request->ajax()) {
            if ($negocio = Negocio::where('url', $url_negocio)->first()) {

                $albumes = Producto::where('productos.negocio_id','=', $negocio->id)
                                        ->where('tipo_id','=',2)
                                        ->where('guardar','=',1)
                                        ->with(['imagenes','relacionados' => function($relacionados){
                                            $relacionados->with('categorias');
                                        }])->paginate($this->cant_reg);

                // $productos = Producto::where('productos.negocio_id','=', $negocio->id)
                //                         ->where('tipo_id','=',1)
                //                         ->where('guardar','=',1)
                //                         ->with(['imagenes','relacionados' => function($relacionados){
                //                             $relacionados->with('categorias');
                //                         }])->get();

                return $albumes;
            }
        }
    }

    public function mostrar_producto(Request $request, $url_negocio, $codigo, $imagen_id =''){

        // if ($request->ajax()) {
            if ($negocio = Negocio::where('url', $url_negocio)->first()) {
                $producto = Producto::where('productos.codigo','=',$codigo)
                        // ->where('tipo_id','=',1)
                        ->where('productos.negocio_id','=', $negocio->id)
                        ->where('guardar','=',1)
                        ->with(['caracteristicas','categorias','imagenes','relacionados' => function($relacionados){
                            $relacionados->with('categorias');
                        }])->first();
                // return $producto;
            }
        // }

        return view('public.producto', compact('negocio','producto', 'imagen_id'));

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
            $logo = $request->file('logo')->store($negocio->url);
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
