<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);
        if ($validator->fails()) {  
            // return "Error";
            return $this->sendError(
                    'Error de validacion',
                    $validator->errors(),
                    422);
        }

        $input = $request->all();
        //ciframos el password
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        //creamos un nuevo token de autenticación
        $token = $user->createToken('laravel-passport')->accessToken;

        $data = [
            'token'=>$token,
            'user'=>$user
        ];
        // return "Exito";
        return $this->sendRespons($data,"Usuario registrado exitosa mente");
    }

    public function login(Request $request){
        // $user = Auth::user();
        // $data = [
        //     "user" => $user
        // ];
        // return $this->sendRespons($data,"Bienvenido");
        if(Auth::attempt(['name' => $request->username, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('laravel-passport')->accessToken;
            $success['token'] = $token;
            $success['name'] =  $user->name;

            return $this->sendRespons($success, 'Usuario logueado con exito.');
        } else {
            return $this->sendError('Desautorizado.', ['error'=>'Desautorizado']);
        }
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
