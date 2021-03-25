<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoteResource;
use App\Models\Lote;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lotes = Lote::latest()->paginate(10);

        return response(['lotes' => LoteResource::collection($lotes), 'message' => 'Obtenidos con exito'], 200);

        // $clients = Lote::all();
    
        // return $this->sendRespons(LoteResource::collection($clients), 'Clientes obtenidos satisfactoriamente.');
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
            'name' => 'required|max:255',
            'description' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error', $validator->errors()]);
        }

        $lote = Lote::create($data);
        return response(['lote' => new LoteResource($lote), 'message' => 'Lote creado con exito'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lote = Lote::find($id);
        // echo $lote1;

        if (is_null($lote)) {
            return response(['message' => 'lote no encontrado']);
        }

        // return $this->response(['lote' => new LoteResource($lote), 'message' => 'Lote obtenido satisfactoriamente.'], 201);
        return response(['lote' => new LoteResource($lote), 'message' => 'lote encontrado'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lote $lote)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Error de validacion.', $validator->errors()]);       
        }

        $lote = Lote::find($request->id);
        $lote->name = $input['name'];
        $lote->description = $input['description'];
        $lote->save();

        return response(['lote' => new LoteResource($lote), 'message' => 'Lote actualizado con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $lote = Lote::find($id);
        $lote->delete();

        return response(['message' => 'Lote eliminado con exito']);
    }
}
