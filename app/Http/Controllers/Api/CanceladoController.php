<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CanceladoResource;
use App\Models\Cancelado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CanceladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cancelado = Cancelado::latest()->paginate(10);

        return response(['cancelado' => CanceladoResource::collection($cancelado), 'message' => 'Obtenidos con exito'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'fecha' => 'required|max:255',
            'factura_id' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error', $validator->errors()]);
        }

        $cancelado = Cancelado::create($data);
        return response(['cancelado' => new CanceladoResource($cancelado), 'message' => 'factura pagada'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cancelado = Cancelado::find($id);
        // echo $cancelado1;

        if (is_null($cancelado)) {
            return response(['message' => 'factura no encontrada']);
        }

        // return $this->response(['cancelado' => new canceladoResource($cancelado), 'message' => 'cancelado obtenido satisfactoriamente.'], 201);
        return response(['cancelado' => new CanceladoResource($cancelado), 'message' => 'factura encontrada'], 200);
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
    public function update(Request $request, cancelado $cancelado)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'fecha' => 'required|max:255',
            'factura_id' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response(['message' => 'Error de validacion.', $validator->errors()]);       
        }

        $cancelado = Cancelado::find($request->id);
        $cancelado->fecha = $input['fecha'];
        $cancelado->factura_id = $input['factura_id'];
        $cancelado->save();

        return response(['cancelado' => new CanceladoResource($cancelado), 'message' => 'factura actualizado con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $cancelado = Cancelado::find($id);
        $cancelado->delete();

        return response(['message' => 'factura eliminada con exito']);
    }
}
