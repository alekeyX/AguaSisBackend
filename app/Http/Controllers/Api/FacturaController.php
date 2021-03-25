<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacturaResource;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FacturaController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factura = Factura::latest()->paginate(10);

        return response(['factura' => FacturaResource::collection($factura), 'message' => 'Obtenidos con exito'], 200);

        // $clients = factura::all();
    
        // return $this->sendRespons(facturaResource::collection($clients), 'Clientes obtenidos satisfactoriamente.');
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
            'num' => 'required|max:255',
            'client_id' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error', $validator->errors()]);
        }

        $factura = Factura::create($data);
        return response(['factura' => new FacturaResource($factura), 'message' => 'factura creada con exito'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factura = Factura::find($id);
        // echo $factura1;

        if (is_null($factura)) {
            return response(['message' => 'factura no encontrada']);
        }

        // return $this->response(['factura' => new facturaResource($factura), 'message' => 'factura obtenido satisfactoriamente.'], 201);
        return response(['factura' => new FacturaResource($factura), 'message' => 'factura encontrada'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, factura $factura)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'num' => 'required|max:255',
            'client_id' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response(['message' => 'Error de validacion.', $validator->errors()]);       
        }

        $factura = Factura::find($request->id);
        $factura->num = $input['num'];
        $factura->lectura1 = $input['lectura1'];
        $factura->lectura2 = $input['lectura2'];
        $factura->total = $input['total'];
        $factura->fecha = $input['fecha'];
        $factura->client_id = $input['client_id'];
        $factura->save();

        return response(['factura' => new FacturaResource($factura), 'message' => 'factura actualizada con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $factura = Factura::find($id);
        $factura->delete();

        return response(['message' => 'factura eliminada con exito']);
    }
}
