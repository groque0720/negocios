<?php

namespace App\Http\Controllers\Categoria;

use App\Categoria;
use App\Http\Controllers\Controller;
use App\Negocio;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $cant_reg = 50;

    public function index()
    {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        // $categorias = $negocio->categorias()->paginate();
        // return $categorias;
        // return view('categorias.index', compact('negocio','categorias'));
        return view('categorias.index',compact('negocio'));
    }

    public function categorias_buscar() {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $categorias = $negocio->categorias()->orderBy('categoria')->paginate($this->cant_reg);
        return $categorias;
    }

    public function categorias_accion(Request $request){

        if ($request->ajax()) {

            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();

            if ($request->accion == "A") {
                $categoria = new Categoria;
                $categoria->negocio_id = $negocio->id;
                $categoria->categoria = $request->formulario['categoria'];
                $categoria->save();
                $respuesta['msg'] = 'ok';
            }

            if ($request->accion == "M") {
                $categoria = $negocio->categorias()->where('id',$request->formulario['categoria_id'])->first();
                if ($categoria != null) {
                    $categoria->categoria = $request->formulario['categoria'];
                    $categoria->save();
                    $respuesta['msg'] = 'ok';
                }else{
                    $respuesta['msg'] = 'error';
                }
            }

            if ($request->accion == "B") {
                $categoria = $negocio->categorias()->where('id',$request->formulario['categoria_id'])->first();
                if ($categoria != null) {
                    $categoria->delete();
                    $respuesta['msg'] = 'ok';
                }else{
                    $respuesta['msg'] = 'error';
                }
            }
            $registros = $request->page * $this->cant_reg;

            if ($negocio->categorias()->count() > $registros) {
                $respuesta['categorias'] = $negocio->categorias()->orderBy('categoria')->limit($registros)->get();
            }else{
                $respuesta['categorias'] = $negocio->categorias()->orderBy('categoria')->get();
            }
            return $respuesta;
        }

        return 'Error';
    }


    public function categorias_buscar_autocompletar(Request $request){
        if ($request->ajax()) {
            $query = $request['query'];
            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
            $categorias = $negocio->categorias()->where('categoria' ,'like','%'.$query.'%')->get();
            return response()->json($categorias);
        }
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
    public function edit($id)
    {
        //
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
