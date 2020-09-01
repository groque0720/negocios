<?php

namespace App\Http\Controllers\Caracteristica;

use App\Caracteristica;
use App\Http\Controllers\Controller;
use App\Negocio;
use Illuminate\Http\Request;

class CaracteristicaController extends Controller
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
        return view('caracteristicas.index',compact('negocio'));
    }

    public function caracteristicas_buscar() {
        $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
        $caracteristicas = $negocio->caracteristicas()->orderBy('caracteristica')->paginate($this->cant_reg);
        return $caracteristicas;
    }

    public function caracteristicas_buscar_autocompletar(Request $request){
        if ($request->ajax()) {
            $query = $request['query'];
            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();
            $caracteristicas = $negocio->caracteristicas()->where('caracteristica' ,'like','%'.$query.'%')->get();
            return response()->json($caracteristicas);
        }
    }

    public function caracteristicas_accion(Request $request){

        if ($request->ajax()) {

            $negocio = Negocio::where('user_id',Auth()->user()->id)->first();

            if ($request->accion == "A") {
                $caracteristica = new Caracteristica;
                $caracteristica->negocio_id = $negocio->id;
                $caracteristica->caracteristica = $request->formulario['caracteristica'];
                $caracteristica->save();
                $respuesta['msg'] = 'ok';
            }

            if ($request->accion == "M") {
                $caracteristica = $negocio->caracteristicas()->where('id',$request->formulario['caracteristica_id'])->first();
                if ($caracteristica != null) {
                    $caracteristica->caracteristica = $request->formulario['caracteristica'];
                    $caracteristica->save();
                    $respuesta['msg'] = 'ok';
                }else{
                    $respuesta['msg'] = 'error';
                }
            }

            if ($request->accion == "B") {
                $caracteristica = $negocio->caracteristicas()->where('id',$request->formulario['caracteristica_id'])->first();
                if ($caracteristica != null) {
                    $caracteristica->delete();
                    $respuesta['msg'] = 'ok';
                }else{
                    $respuesta['msg'] = 'error';
                }
            }
            $registros = $request->page * $this->cant_reg;

            if ($negocio->caracteristicas()->count() > $registros) {
                $respuesta['caracteristicas'] = $negocio->caracteristicas()->orderBy('caracteristica')->limit($registros)->get();
            }else{
                $respuesta['caracteristicas'] = $negocio->caracteristicas()->orderBy('caracteristica')->get();
            }
            return $respuesta;
        }

        return 'Error';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
