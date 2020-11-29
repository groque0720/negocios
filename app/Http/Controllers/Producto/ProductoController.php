<?php

namespace App\Http\Controllers\Producto;

use App\Caracteristica;
use App\CaracteristicaProducto;
use App\Categoria;
use App\CategoriaProducto;
use App\Http\Controllers\Controller;
use App\Negocio;
use App\Producto;
use App\ProductoImagen;
use App\ProductoRelacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $cant_reg = 100;


    public function index()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        return view('productos.index', compact('negocio'));
    }

    public function albumes()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        return view('productos.albumes', compact('negocio'));
    }

    public function productos_buscar($tipo_id) {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        if ($tipo_id == 1) {
           $productos = $negocio->productos()->where('tipo_id',$tipo_id)->where('guardar',1)->orderBy('producto')->paginate($this->cant_reg);
        }else{
            $productos = $negocio->productos()->where('tipo_id',$tipo_id)->where('guardar',1)->orderByDesc('id')->paginate($this->cant_reg);
        }
        return $productos;
    }

    public function buscar_productos_relacionados($id){

        // $relacionados = ProductoRelacion::where('album_id',$id)->get();

        // $producos_relacionados = [];

        // foreach ($relacionados as $relacion) {
        //     if ($producto = Producto::find($relacion->producto_id)) {
        //        array_push($producos_relacionados, $producto);
        //     }
        // }
        $producos_relacionados = Producto::find($id)->relacionados()->get();
        return $producos_relacionados;
    }

    public function producto_relacionar(Request $request){

        $album_id = $request->album_id;
        $producto_id_relacionar = $request->relacionar_producto_id;

        $producto_relacion = new ProductoRelacion();
        $producto_relacion->album_id = $album_id;
        $producto_relacion->producto_id = $producto_id_relacionar;
        $producto_relacion->save();

        return $this->buscar_productos_relacionados($album_id);

    }

    public function producto_relacionado_eliminar(Request $request){
        if ($request->ajax()) {
            $album_id = $request->album_id;
            $producto_id = $request->producto_id;
            ProductoRelacion::where('album_id',$album_id)->where('producto_id', $producto_id)->delete();
            return 'ok';
        }
    }


    public function productos_buscar_autocompletar(Request $request){
        if ($request->ajax()) {
            $query = $request['query'];
            $tipo_id = $request['tipo_id'];
            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
            $productos = $negocio->productos()->where('tipo_id', $tipo_id)->where('producto' ,'like','%'.$query.'%')->get();
            return response()->json($productos);
        }
    }

    public function producto_caracteristicas_activas(Request $request){

        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $negocio_caracteristicas = $negocio->caracteristicas()->orderBy('caracteristica')->get();
        $producto_caracteristicas = [];
        $producto_codigo = $request->producto_codigo;
        if ($producto_codigo) {
            $producto = Producto::where('codigo', $producto_codigo)->first();
            $producto_caracteristicas = $producto->caracteristicas()->pluck('caracteristica_id')->values()->all();
        }

        $caracteristicas = [];

        foreach ($negocio_caracteristicas  as $negocio_caracteristica ) {
            $aux['id'] = $negocio_caracteristica['id'];
            $aux['caracteristica'] = $negocio_caracteristica['caracteristica'];
            $aux['seleccion'] = in_array($negocio_caracteristica['id'], $producto_caracteristicas);
            $aux['seleccion_confirmacion'] = in_array($negocio_caracteristica['id'], $producto_caracteristicas);

            if ($aux['seleccion']) {
                $aux['valor'] = CaracteristicaProducto::where('caracteristica_id', $negocio_caracteristica['id'])
                                ->where('producto_id',$producto->id)->first()->valor;
                $aux['posicion'] = CaracteristicaProducto::where('caracteristica_id', $negocio_caracteristica['id'])
                                ->where('producto_id',$producto->id)->first()->posicion;
            }else{
                $aux['valor'] = '';
                $aux['posicion'] = 99;
            }
            array_push($caracteristicas, $aux);
        }
        return $caracteristicas;
    }

    public function producto_agregar_caracteristica(Request $request){
        if ($request->ajax()) {

            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
            $caracteristica = new Caracteristica;
            $caracteristica->negocio_id = $negocio->id;
            $caracteristica->caracteristica = $request->formulario['caracteristica'];
            $caracteristica->save();

            return $caracteristica;

            //areturn response()->json($this->producto_buscar_caracteristicas($request->formulario['producto_codigo']));
        }
    }


    public function producto_categorias_activas(Request $request){

        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $negocio_categorias = $negocio->categorias()->orderBy('categoria')->get();

        $producto_codigo = $request->producto_codigo;

        $producto_categorias = [];

        if ($producto_codigo) {
            $producto = Producto::where('codigo', $producto_codigo)->first();
            $producto_categorias = $producto->categorias()->pluck('categoria_id')->values()->all();
            // $producto_categorias_posicion = $producto->categorias()->withPivot('posicion')->get();
        }
        // $posicion = array_search(1, $producto_categorias);
        // return $producto_categorias_posicion;

        $categorias = [];

        foreach ($negocio_categorias  as $negocio_categoria ) {


            // if ($producto_categorias) {
            //     $index_arreglo = array_search($negocio_categoria['id'], $producto_categorias);
            //     $aux['posicion'] = $producto_categorias_posicion[$index_arreglo]['pivot']['posicion'];
            // }else{
            //     $aux['posicion'] = 99;
            // }

            $aux['posicion'] = 99;
            if (in_array($negocio_categoria['id'], $producto_categorias)) {
                $posicion = DB::select('SELECT categorias_productos.posicion FROM
                                categorias_productos
                                WHERE categorias_productos.categoria_id = ? AND categorias_productos.producto_id = ?',
                                [$negocio_categoria['id'], $producto->id])[0];
                $aux['posicion'] = $posicion->posicion;
            }


            $aux['id'] = $negocio_categoria['id'];
            $aux['categoria'] = $negocio_categoria['categoria'];
            // $index_arreglo = array_search($negocio_categoria['id'], $producto_categorias);
            // $aux['posicion'] = $producto_categorias_posicion[$index_arreglo]['pivot']['posicion'];
            $aux['seleccion'] = in_array($negocio_categoria['id'], $producto_categorias);
            $aux['seleccion_confirmacion'] = in_array($negocio_categoria['id'], $producto_categorias);


            array_push($categorias, $aux);
        }
        return $categorias;
    }

    public function producto_agregar_categoria(Request $request){
        if ($request->ajax()) {

            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
            $categoria = new Categoria;
            $categoria->negocio_id = $negocio->id;
            $categoria->categoria = $request->formulario['categoria'];
            $categoria->save();

            return $categoria;
        }
    }

    public function producto_obtener_imagenes (Request $request, $id) {
        $producto = Producto::find($id);
        $borrado = $producto->imagenes()->where('borrar',1)->delete();
        return $imagenes = $producto->imagenes()->where('borrar',0)->orderBy('posicion')->get();
    }


    public function producto_imagenes_guardar(Request $request)
    {
        $imageName = md5(microtime()).'.'.strtolower($request->file->getClientOriginalExtension());
        $imageName = str_replace(' ', '_', $imageName);

        if ($request->file->getClientOriginalExtension() == 'mp4') {
            $request->file('file')->storeAs('public/'.$request->negocio_url, $imageName);
            $url = $request->negocio_url.'/'.$imageName;
        }else{
            // $request->file('file')->storeAs('public/'.$request->negocio_url, $imageName);
            // $url = $request->negocio_url.'/'.$imageName;

            $image = $request->file('file');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(800, null, function($constraint) {
                 $constraint->aspectRatio();
                 $constraint->upsize();
            });
            $image_resize->orientate();
            // $image_resize->storeAs('public/'.$request->negocio_url, $imageName);
            $image_resize->save(public_path('storage/'.$request->negocio_url.'/'.$imageName),72);
            $url = $request->negocio_url.'/'.$imageName;
            // $nombre_archivo = time() . "." . $request->file('file')->extension();
            // $image_resize->save(public_path('images/' .$imageName));
        }
        $producto_imagen = new ProductoImagen;
        $producto_imagen->producto_id = $request->producto_id;
        $producto_imagen->imagen = $url;
        $producto_imagen->posicion = 9999;
        $producto_imagen->save();

        $this->producto_imagen_principal($request->producto_id);

        // $id = $request->negocio['id'];
        // return $id;
        return response()->json($request);
    }

    public function producto_borrar_imagenes(Request $request, $imagen_id) {
        $imagen = ProductoImagen::find($imagen_id);
        $producto_id = $imagen->producto_id;
        Storage::delete('public/'.$imagen->imagen);
        $imagen->delete();
        $this->producto_imagen_principal($producto_id);

        // return true;
    }

    public function producto_imagen_principal($producto_id){
        $producto = Producto::find($producto_id);
        if ($primer_imagen = $producto->imagenes()->orderBy('posicion')->first()) {
            $producto->imagen_ppal = $primer_imagen->imagen;
        }
        $producto->save();
    }

    // public function producto_imagenes_guardar (Request $request) {
    //     return $request;
    // }

    public function producto_guardar (Request $request) {
        $producto_form = $request->producto;
        $caracteristicas_form = $request->caracteristicas;
        $categorias_form = $request->categorias;
        $imagenes_form =  $request->imagenes;

        // Producto
        if (isset($producto_form['id'])) {
            $producto = Producto::find($producto_form['id']);
        }else{
            $producto = new Producto();
        }
        $producto->imagen_ppal =
        $producto->producto = $producto_form['producto'];
        $producto->descripcion = $producto_form['descripcion'];
        $producto->precio = $producto_form['precio'];
        $producto->precio_obs = $producto_form['precio_obs'];
        $producto->guardar = 1;
        $producto->save();

        // Caracteristicas
        $posicion = 0;
        foreach ($caracteristicas_form as $caracteristica_form) {
            if ($caracteristica_form['seleccion_confirmacion']) {

                $caracteristica_producto = CaracteristicaProducto::where('caracteristica_id',$caracteristica_form['id'])
                                        ->where('producto_id',$producto['id'])->first();

                if (!$caracteristica_producto) {
                    $caracteristica_producto = new CaracteristicaProducto();
                }

                $caracteristica_producto->caracteristica_id = $caracteristica_form['id'];
                $caracteristica_producto->producto_id = $producto['id'];
                $caracteristica_producto->valor = $caracteristica_form['valor'] ?? '';
                $caracteristica_producto->posicion = $posicion;
                $caracteristica_producto->save();

                $posicion++;
            }else{
                $res = CaracteristicaProducto::where('caracteristica_id',$caracteristica_form['id'])
                                        ->where('producto_id',$producto['id'])
                                        ->forceDelete();

            }
        }

        // caracteristicas

                    // $categorias_seleccion = [];
                    // foreach ($categorias_form as $categoria_form) {
                    //     if ($categoria_form['seleccion_confirmacion']) {
                    //         array_push($categorias_seleccion, $categoria_form['id']);
                    //     }
                    // }

                    // $producto->categorias()->sync($categorias_seleccion);


        // return $categorias_form;

        $posicion = 0;
        foreach ($categorias_form as $key => $categoria_form) {
            if ($categoria_form['seleccion_confirmacion']){
                $categoria = CategoriaProducto::where('producto_id',$producto->id)->where('categoria_id',$categoria_form['id'])->first();
                if ($categoria == null) {
                    $categoria = new CategoriaProducto;
                    $categoria->producto_id = $producto->id;
                    $categoria->categoria_id = $categoria_form['id'];
                    $categoria->posicion = $posicion;
                    $categoria->save();
                }else{
                    $categoria->posicion = $posicion;
                    $categoria->save();
                }
                $posicion++;
            }else{
                CategoriaProducto::where('producto_id',$producto->id)->where('categoria_id',$categoria_form['id'])->delete();
            }
        }



        //imagenes
        foreach ($imagenes_form as $key=>$imagen) {
            if ($imagen['borrar'] == 0) {
                $producto_imagen = ProductoImagen::find($imagen['id']);
                $producto_imagen->posicion = $key;
                $producto_imagen->confirmada = 1;
                $producto_imagen->save();
            }
            // if ($imagen['borrar'] == 1) {
                // Storage::delete('public/'.$request->negocio['url'].'/'.$imagen['imagen']);
                // $producto_imagen->delete();
            // }else{
                // $producto_imagen->posicion = $key;
                // $producto_imagen->confirmada = 1;
                // $producto_imagen->save();
            // }
        }

        $this->producto_imagen_principal($producto->id);

        return 'ok';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipo_id = 1)
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $producto = new Producto();
        $producto->negocio_id = $negocio->id;
        $producto->tipo_id = $tipo_id; // es producto, no es album
        $producto->producto = '';
        $producto->descripcion = '';
        $producto->codigo = md5(microtime());
        $producto->precio = 0;
        $producto->guardar = 0;
        $producto->save();
        return redirect()->route('productos.edit',['codigo' => $producto->codigo]);
        // return view('productos.create', compact('negocio','producto'));
    }

    public function producto_eliminar($id){
        $producto = Producto::find($id);
        $caracteristicas = CaracteristicaProducto::where('producto_id',$id)->forceDelete();
        $categorias = CategoriaProducto::where('producto_id',$id)->forceDelete();
        $imagenes = $producto->imagenes()->get();
        foreach ($imagenes as $imagen) {
            Storage::delete('public/'.$imagen->imagen);
        }
        // borro las imagenes del producto
        $imagenes = ProductoImagen::where('producto_id',$id)->forceDelete();
        // elimino las relaciones de los albumes que tiene con el productro que estoy por eliminar
        $productos_relacion = ProductoRelacion::where('producto_id', $id)->forceDelete();
        // elimino el producto propiamente.
        $producto->forceDelete();

        return 'ok';
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
    public function edit($codigo)
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $producto = $negocio->productos()->where('codigo',$codigo)->first();
        return view('productos.edit', compact('negocio','producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
