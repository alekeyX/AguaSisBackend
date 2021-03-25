<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TelefonoResource;
use App\Models\Telefono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelefonoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $telefonos = Telefono::latest()->paginate(10);

        return response(['telefonos' => TelefonoResource::collection($telefonos), 'message' => 'Obtenidos con exito'], 200);

        // $clients = telefono::all();
    
        // return $this->sendRespons(telefonoResource::collection($clients), 'Clientes obtenidos satisfactoriamente.');
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
            'numero' => 'required|max:255',
            'client_id' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error', $validator->errors()]);
        }

        $telefono = Telefono::create($data);
        return response(['telefono' => new TelefonoResource($telefono), 'message' => 'telefono creado con exito'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $telefono = Telefono::find($id);
        // echo $telefono1;

        if (is_null($telefono)) {
            return response(['message' => 'telefono no encontrado']);
        }

        // return $this->response(['telefono' => new telefonoResource($telefono), 'message' => 'telefono obtenido satisfactoriamente.'], 201);
        return response(['telefono' => new TelefonoResource($telefono), 'message' => 'telefono encontrado'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, telefono $telefono)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'numero' => 'required',
            'client_id' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Error de validacion.', $validator->errors()]);       
        }

        $telefono = Telefono::find($request->id);
        $telefono->numero = $input['numero'];
        $telefono->client_id = $input['client_id'];
        $telefono->save();

        return response(['telefono' => new TelefonoResource($telefono), 'message' => 'telefono actualizado con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $telefono = Telefono::find($id);
        $telefono->delete();

        return response(['message' => 'telefono eliminado con exito']);
    }
}
