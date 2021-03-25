<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController as ApiController;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Client as ClientResources;

class ClientController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
    
        return $this->sendRespons(ClientResources::collection($clients), 'Clientes obtenidos satisfactoriamente.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cod' => 'required',
            'name' => 'required',
            'lote_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validacion.', $validator->errors());       
        }

        $client = Client::create($input);

        return $this->sendRespons(new ClientResources($client), 'Cliente creado satisfactoriamente.');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (is_null($client)) {
            return $this->sendError('Cliente no encontrado.');
        }

        return $this->sendRespons(new ClientResources($client), 'Cliente obtenido satisfactoriamente.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cod' => 'required',
            'name' => 'required',
            'lote_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validacion.', $validator->errors());       
        }

        $client = Client::find($request->id);
        $client->cod = $input['cod'];
        $client->name = $input['name'];
        $client->detail = $input['detail'];
        $client->lote_id = $input['lote_id'];
        $client->save();

        return $this->sendRespons(new ClientResources($client), 'Cliente actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    // public function delete(Client $client)
    {
        $client = Client::find($id);
        $client->delete();

        return $this->sendRespons([], 'Cliente eliminado satisfactoriamente.');
    }
}
