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
    protected $cant_reg = 15;

    public function public_index(Request $request, $url_negocio){


            if ($request->session()->has('session_rand')) {
                if((time() - $request->session()->get('session_rand')) > 500){
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
    public function buscar_imagenes_random(Request $request, $url_negocio, $producto_id = ''){

        if ($request->ajax() && $negocio = Negocio::where('url', $url_negocio)->first()) {

            $imagenes = ProductoImagen::select('productos_imagenes.*',
                                                'productos.producto',
                                                'productos.descripcion',
                                                'productos.precio',
                                                'productos.precio_obs',
                                                'productos.codigo AS producto_codigo')
                                        ->join('productos', 'productos.id', '=', 'productos_imagenes.producto_id')
                                        ->where('productos.negocio_id','=', $negocio->id)
                                        ->where('productos.guardar','=', 1)
                                        ->orderBy(DB::raw('RAND('.$request->session()->get('session_rand').')'))
                                        //->inRandomOrder($request->session()->get('session_rand'))
                                        ->paginate($this->cant_reg);
            return $imagenes;
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
            if ($negocio = Negocio::where('url', $url_negocio)->with(['redes_sociales'])->first()) {
                $producto = Producto::where('productos.codigo','=',$codigo)
                        // ->where('tipo_id','=',1)
                        ->where('productos.negocio_id','=', $negocio->id)
                        ->where('guardar','=',1)
                        ->with(['caracteristicas',
                                'categorias',
                                'imagenes',
                                'relacionados' => function($relacionados){
                            $relacionados->with('categorias');
                        }])->first();
                // return $producto;
            }
        // }

        if ($imagen_id == '') {
            $imagen_id = $producto->imagenes[0]->id;
            $imagen_url = $producto->imagenes[0]->imagen;
        }else{
            $imagen_id = ProductoImagen::find($imagen_id)->id;
            $imagen_url = ProductoImagen::find($imagen_id)->imagen;
        }

        return view('public.producto', compact('negocio','producto', 'imagen_id','imagen_url'));

    }

    public function mostrar_productos_mismas_categorias(Request $request){

        // $categorias_buscar = [];
        $cat_search = '';

        // return $request->categorias;

        $albumes_ = [];
        $productos_ = [];

        // return $request->categorias;

        $cont = 0;

        foreach ($request->categorias as $categoria) {
            // array_push($categorias_buscar, json_decode($categoria)->id);
            $cat_search .= json_decode($categoria)->id.', ';
            $categoria_id = json_decode($categoria)->id;

            $albumes = DB::select("SELECT DISTINCT
                        albumes.*
                        FROM
                        productos AS albumes
                        INNER JOIN productos_relaciones ON productos_relaciones.album_id = albumes.id
                        INNER JOIN productos ON productos_relaciones.producto_id = productos.id
                        INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
                        WHERE
                        albumes.id <> ? AND
                        categorias_productos.categoria_id = ?
                        LIMIT 10", [$request->producto_id, $categoria_id]);

            $productos = DB::select("SELECT DISTINCT productos.*
                        FROM
                        productos
                        INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
                        WHERE
                        productos.id <> ? AND
                        productos.tipo_id = 1 AND
                        productos.guardar = 1 AND
                        categorias_productos.categoria_id = ?
                       LIMIT 10", [$request->producto_id, $categoria_id]);
            if ($cont == 0) {
                array_merge($productos_, $productos);
                array_merge($albumes_, $albumes);
            }

            $cont++;

            // array_merge($productos_, $productos_);
            // array_merge($albumes_, $albumes_);

        }

        return $productos_;

        $cat_search .="0";


        // $albumes_ = DB::select("SELECT DISTINCT
        //                         albumes.*
        //                         FROM
        //                         productos AS albumes
        //                         INNER JOIN productos_relaciones ON productos_relaciones.album_id = albumes.id
        //                         INNER JOIN productos ON productos_relaciones.producto_id = productos.id
        //                         INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
        //                         WHERE
        //                         albumes.id <> ?
        //                         -- categorias_productos.categoria_id IN ($cat_search)
        //                         ORDER BY FIELD (categorias_productos.categoria_id, $cat_search) LIMIT 10", [$request->producto_id]);

        // $productos_ = DB::select("SELECT DISTINCT productos.*
        //                         FROM
        //                         productos
        //                         INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
        //                         WHERE
        //                         productos.id <> ? AND
        //                         productos.tipo_id = 1 AND
        //                         productos.guardar = 1
        //                         -- categorias_productos.categoria_id IN ($cat_search)
        //                         ORDER BY FIELD (categorias_productos.categoria_id, $cat_search) LIMIT 10", [$request->producto_id]);

        $cant_album = count($albumes_);
        $cant_productos = count($productos_);

        $cant_max = $cant_productos >= $cant_album ? $cant_productos : $cant_album;

        $productos = [];

        for ($i=0; $i < $cant_max; $i++) {
           if ($i < $cant_productos) {
               array_push($productos, $productos_[$i]);
           }
            if ($i < $cant_album) {
               array_push($productos, $albumes_[$i]);
           }
        }

        // $productos = array_merge($albumes, $productos);

        // shuffle($productos);


        // $productos = Producto::where('productos.negocio_id','=', $request->negocio_id)
        //                         ->where('tipo_id','=',1)
        //                         ->where('guardar','=',1)
        //                         ->with(['categorias' => function($categorias){
        //                             $categorias->whereIn('categoria', $categorias_buscar);
        //                         }])->get();

        return $productos;


    }


    public function mostrar_productos_categoria(Request $request, $url_negocio, $categoria){

        if ($negocio = Negocio::where('url', $url_negocio)->first()) {
                $productos = Producto::where('productos.negocio_id','=', $negocio->id)
                                        ->where('tipo_id','=',1)
                                        ->where('guardar','=',1)
                                        ->with(['categorias' => function($categorias){
                                            $categorias->where('categoria','=', 'bebes');
                                        }])->paginate($this->cant_reg);

                // $producto = DB::select('SELECT productos.*
                //                         FROM
                //                         productos
                //                         INNER JOIN categorias_productos ON productos.id = categorias_productos.producto_id
                //                         INNER JOIN categorias ON categorias_productos.categoria_id = categorias.id
                //                         WHERE
                //                         categorias.categoria = ?',[$categoria]);
            }
        return $productos;
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

        $ext_imagenes = ['jpg', 'jpeg', 'png', 'gif'];

        if ($request->hasFile('logo') AND  in_array( $request->file('logo')->extension(), $ext_imagenes)) {
            if ($negocio->logo != 'public/logo_default_negocio.png') {
                Storage::delete('/public/'.$negocio->logo);
            }
            $imageName = md5(microtime()).'.'.$request->file('logo')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $imageName);
            Storage::disk('local')->PutFileAs('/public/'.$negocio->url, $request->file('logo'), $imageName);
            $negocio->logo = $negocio->url.'/'.$imageName;
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
