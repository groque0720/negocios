<?php

namespace App\Http\Controllers\Negocio;

use App\Categoria;
use App\Http\Controllers\Controller;
use App\Negocio;
use App\Producto;
use App\ProductoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NegocioController extends Controller
{
    protected $cant_reg = 20;

    public function public_index(Request $request, $url_negocio){

            $query = $request->q;

            if ($request->session()->has('session_rand')) {
                if((time() - $request->session()->get('session_rand')) > 500){
                    $request->session()->put('session_rand', time());
                }
            }else{
                $request->session()->put('session_rand', time());
            }
            // dd($request->session()->get('session_rand'));

        if ($negocio = Negocio::where('url', $url_negocio)->first()) {
            return view('public.index', compact('negocio','query'));
        }else{
            return 'no se encuentra..';
        }
    }


    public function items_de_busqueda(Request $request){
        // return $request->negocio_url; $query = $request->query;
        $negocio = Negocio::where('url', $request->negocio_url)->first();
        $productos = $negocio->productos()->distinct('producto')->select('producto as item')->where('guardar',1)->get();
        $categorias = $negocio->categorias()->select('categoria as item')->get();
        $item = Arr::collapse([$productos, $categorias]);
        $item = Arr::pluck($item,'item');
        $item = array_unique($item);
        sort($item);
        return $item;

    }

    public function buscar_imagenes_random_query ($request, $negocio, $query, $secundario){

        $categorias =  $negocio->categorias()->pluck('categoria')->values()->all();
        $categorias = array_map('strtolower', $categorias);

       if (in_array(strtolower($query), $categorias) && $secundario == true) {
           $categoria_id = Categoria::where('negocio_id', $negocio->id)->where('categoria', $query)->first()->id;

           $imagenes = DB::table('productos_imagenes')
                            ->distinct('productos_imagenes.id')
                            ->join('productos_relaciones','productos_relaciones.album_id','=','productos_imagenes.producto_id')
                            ->join('categorias_productos','categorias_productos.producto_id','=','productos_relaciones.producto_id')
                            // ->join('productos','productos.id','=','categorias_productos.producto_id')
                            ->join('productos AS albumes','albumes.id','=','productos_relaciones.album_id')
                            ->select('productos_imagenes.*',
                                    'albumes.producto',
                                    'albumes.descripcion',
                                    'albumes.precio',
                                    'albumes.precio_obs',
                                    'albumes.codigo AS producto_codigo')
                            ->where('categorias_productos.categoria_id','=', $categoria_id)
                            ->paginate($this->cant_reg);


           return $imagenes;
        }

        if (in_array(strtolower($query), $categorias)) {
            // return $this->buscar_albumes_categorias_query($request, $negocio, $query);

                $imagenes = ProductoImagen::select('productos_imagenes.*',
                        'productos.producto',
                        'productos.descripcion',
                        'productos.precio',
                        'productos.precio_obs',
                        'productos.codigo AS producto_codigo')
                ->distinct('productos_imagenes.producto_id')
                ->join('productos', 'productos.id', '=', 'productos_imagenes.producto_id')
                ->rightJoin('categorias_productos', 'categorias_productos.producto_id', '=', 'productos_imagenes.producto_id')
                ->rightjoin('categorias', 'categorias.id', '=', 'categorias_productos.categoria_id')
                ->where('categorias.negocio_id','=', $negocio->id)
                ->where('productos.negocio_id','=', $negocio->id)
                ->where('productos.guardar','=', 1)
                ->where('categorias.categoria','like',$query)
                // ->whereRaw('MATCH (productos.producto, productos.descripcion) AGAINST ("'.$query.'")')
                // ->WhereRaw("MATCH (categorias.categoria) AGAINST ('$query.')")
                ->paginate($this->cant_reg);

        }else{
                $imagenes = ProductoImagen::select('productos_imagenes.*',
                        'productos.producto',
                        'productos.descripcion',
                        'productos.precio',
                        'productos.precio_obs',
                        'productos.codigo AS producto_codigo')
                ->rightJoin('productos', 'productos.id', '=', 'productos_imagenes.producto_id')
                // ->Join('categorias_productos', 'categorias_productos.producto_id', '=', 'productos_imagenes.producto_id')
                // ->join('categorias', 'categorias.id', '=', 'categorias_productos.categoria_id')
                // ->with([])
                ->where('productos.negocio_id','=', $negocio->id)
                ->where('productos.guardar','=', 1)
                ->whereRaw('MATCH (productos.producto, productos.descripcion) AGAINST ("'.$query.'")')
                // ->OrwhereRaw('MATCH (categorias.categoria) AGAINST ("'.$query.'")')
                ->paginate($this->cant_reg);
        }

        return $imagenes;

    }

    // public function buscar_albumes_categorias_query (Request $request, $negocio, $categoria) {

    //     $imagenes = Producto::select('productos.producto',
    //                 'productos.descripcion',
    //                 'productos.precio',
    //                 'productos.precio_obs',
    //                 'productos.codigo AS producto_codigo',
    //                 'productos_imagenes.*')
    //                 ->join('productos_imagenes', 'productos_imagenes.producto_id', '=', 'productos.id')
    //                 ->where('productos.negocio_id','=', $negocio->id)
    //                 ->where('guardar','=',1)
    //                 ->whereHas('categorias', function($categorias) use($categoria){
    //                     $categorias->where('categoria',$categoria);
    //                 })
    //                 ->paginate($this->cant_reg);

    //                 return $imagenes;
    // }

    // Popurri
    public function buscar_imagenes_random(Request $request, $url_negocio, $producto_id = ''){
        if ($request->ajax() && $negocio = Negocio::where('url', $url_negocio)->first()) {
            if ($request->q != '') {
                $query = $request->q;
                if ($request->secundario == true) {
                   $secundario = true;
                }else{
                    $secundario = false;
                }
                return $this->buscar_imagenes_random_query($request, $negocio, $query, $secundario);
            }else{
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

        // $albumes_ = [];
        $productos_ = [];
        // $cant_album = 0;
        $cant_productos = 0;

        foreach ($request->categorias as $categoria) {

            $categoria_id = json_decode($categoria)->id;

            // $albumes = DB::select("SELECT DISTINCT albumes.*
            //                         FROM
            //                         productos AS albumes
            //                         INNER JOIN productos_relaciones ON productos_relaciones.album_id = albumes.id
            //                         INNER JOIN productos ON productos_relaciones.producto_id = productos.id
            //                         INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
            //                         WHERE
            //                         albumes.id <> ? AND
            //                         categorias_productos.categoria_id = ?
            //                         LIMIT 50", [$request->producto_id, $categoria_id]);

            $productos = DB::select("SELECT DISTINCT productos.*
                                        FROM
                                        productos
                                        INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
                                        WHERE
                                        productos.id <> ? AND
                                        productos.tipo_id = 1 AND
                                        productos.guardar = 1 AND
                                        categorias_productos.categoria_id = ?
                                       LIMIT 50", [$request->producto_id, $categoria_id]);

            // foreach ($albumes as $album) {
            //     if (!in_array($album, $albumes_)) {
            //        array_push($albumes_, $album);
            //        $cant_album++;
            //     }

            // }
            foreach ($productos as $producto) {
                if (!in_array($producto, $productos_)) {
                    array_push($productos_, $producto);
                    $cant_productos++;
                }
            }

        }

        // $albumes_ =  array_map("unserialize", array_unique(array_map("serialize", $albumes_)));
        // $productos_ =  array_map("unserialize", array_unique(array_map("serialize", $productos_)));

        // $cant_album = count($albumes_);
        // $cant_productos = count($productos_);

        // $cant_max = $cant_productos >= $cant_album ? $cant_productos : $cant_album;

        $productos = [];

        for ($i=0; $i < $cant_productos; $i++) {
           if ($i < $cant_productos) {
               array_push($productos, $productos_[$i]);
           }
           //  if ($i < $cant_album) {
           //     array_push($productos, $albumes_[$i]);
           // }
        }
        return $productos;
    }

    public function mostrar_albumes_mismas_categorias(Request $request){

        $albumes_ = [];
        // $productos_ = [];
        $cant_album = 0;
        // $cant_productos = 0;

        foreach ($request->categorias as $categoria) {

            $categoria_id = json_decode($categoria)->id;

            $albumes = DB::select("SELECT DISTINCT albumes.*
                                    FROM
                                    productos AS albumes
                                    INNER JOIN productos_relaciones ON productos_relaciones.album_id = albumes.id
                                    INNER JOIN productos ON productos_relaciones.producto_id = productos.id
                                    INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
                                    WHERE
                                    albumes.id <> ? AND
                                    categorias_productos.categoria_id = ?
                                    LIMIT 50", [$request->producto_id, $categoria_id]);

            // $productos = DB::select("SELECT DISTINCT productos.*
            //                             FROM
            //                             productos
            //                             INNER JOIN categorias_productos ON categorias_productos.producto_id = productos.id
            //                             WHERE
            //                             productos.id <> ? AND
            //                             productos.tipo_id = 1 AND
            //                             productos.guardar = 1 AND
            //                             categorias_productos.categoria_id = ?
            //                            LIMIT 50", [$request->producto_id, $categoria_id]);

            foreach ($albumes as $album) {
                if (!in_array($album, $albumes_)) {
                   array_push($albumes_, $album);
                   $cant_album++;
                }

            }
            // foreach ($productos as $producto) {
            //     if (!in_array($producto, $productos_)) {
            //         array_push($productos_, $producto);
            //         $cant_productos++;
            //     }
            // }

        }

        // $albumes_ =  array_map("unserialize", array_unique(array_map("serialize", $albumes_)));
        // $productos_ =  array_map("unserialize", array_unique(array_map("serialize", $productos_)));

        // $cant_album = count($albumes_);
        // $cant_productos = count($productos_);

        // $cant_max = $cant_productos >= $cant_album ? $cant_productos : $cant_album;

        $albumes = [];

        for ($i=0; $i < $cant_album; $i++) {
           // if ($i < $cant_productos) {
           //     array_push($productos, $productos_[$i]);
           // }
            if ($i < $cant_album) {
               array_push($albumes, $albumes_[$i]);
           }
        }
        return $albumes;
    }





    public function  productos_categoria_filtro(Request $request, $url_negocio, $categoria){

        if ($negocio = Negocio::where('url', $url_negocio)->first()) {
                $productos = Producto::where('productos.negocio_id','=', $negocio->id)
                                        // ->where('tipo_id','=',1)
                                        ->where('guardar','=',1)
                                        ->with(['categorias'])
                                        ->whereHas('categorias', function($categorias) use($categoria){
                                            $categorias->where('categoria',$categoria);
                                        })
                                        ->paginate($this->cant_reg);
            }

        return $productos;

    }

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
