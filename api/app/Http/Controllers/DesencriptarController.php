<?php

namespace App\Http\Controllers;
use \Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class DesencriptarController extends BaseController
{
    public function index(){
        // Inicializamos una variable para almacenar un json nulo
        $json = null;
        // Primero obtenemos todos los registros y los almacenamos en un array

        $json = array(
            'status' => 200,
            'detalle' => "Registro no encontrado."
        );
        // Devolvemos la respuesta en un Json
        return response()->json($json);
    }
}
