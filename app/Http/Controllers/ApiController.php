<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    // return exito
    public function sendRespons($result, $message){
        $response = [
            'success'=>	true,
            'data' => $result,
            'message'=>$message
        ];
        return response()->json($response,200);
    }

    // return "Error"
    public function sendError($error, $errorMessage = [], $code = 404){
        $response = [
            'success' => false,
            'error' => $error,
            'errormessage' => $errorMessage
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

    return response()->json($response, $code);
}
}
