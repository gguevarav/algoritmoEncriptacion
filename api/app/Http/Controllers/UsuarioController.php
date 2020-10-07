<?php

namespace App\Http\Controllers;
use \Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;

class UsuarioController extends BaseController
{
    public function index(){
        // Primero obtendremos el array de los Datos
        $Datos = Usuario::all();

        // Verificamos que el array no esté vacio
        if (!empty($Datos[0])) {
            $json = array(
                'status' => 200,
                'total' => count($Datos),
                'detalle' => $Datos
            );
        }else{
            $json = array(
                'status' => 200,
                'total' => 0,
                'detalle' => "No hay registros"
            );
        }
        // Mostramos la información como un json
        return response()->json($json);
    }

    public function store(Request $request){
        // Creamos un json nulo
        $json = null;
        // Recogemos los Datos que almacenaremos, los ingresamos a un array
        $Datos = array("NombreApellidoUsuario"=>$request->NombreApellidoUsuario,
                       "ContraseniaUsuario"=>$request->ContraseniaUsuario);

        // Validamos que los Datos no estén vacios
        if(!empty($Datos)){
            // Separamos la validación
            // Reglas
            $Reglas = [
                "NombreApellidoUsuario" => 'required|string|max:255',
                "ContraseniaUsuario" => 'required|string|max:255'];

            $Mensajes = [
                "NombreApellidoUsuario.required" => 'Es necesario agregar un nombre',
                "ContraseniaUsuario.required" => 'Es necesario agregar una contraseña'];
            // Validamos los Datos antes de insertarlos en la base de Datos
            $validacion = Validator::make($Datos,$Reglas,$Mensajes);

            //return echo "Hola";
            // Revisamos la validación
            if($validacion->fails()){
                // Devolvemos el mensaje que falló la validación de Datos
                $json = array(
                    "status" => 404,
                    "detalle" => "Los registros tienen errores",
                    "errores" => $validacion->errors()->all()
                );
            }else{
                // instanciamos un nuevo objeto para registro
                $Rol = new Usuario();

                // Ingresamos los datos
                $Rol->NombreApellidoUsuario = $Datos["NombreApellidoUsuario"];
                $Rol->ContraseniaUsuario = $Datos["ContraseniaUsuario"];
                $Rol->ContraseniaEncriptada = $this->encriptarDatos($Datos["ContraseniaUsuario"]);

                // Ejecutamos la acción de guardar
                $Rol->save();

                $json = array(
                    "status" => 200,
                    "detalle" => "Registro exitoso",
                    "contreseniaEncriptada" => $this->encriptarDatos($Datos["ContraseniaUsuario"])
                );
            }
        }else{
            $json = array(
                "status" => 404,
                "detalle" => "Registro con errores"
            );
        }
        // Devolvemos la respuesta en un Json
        return response()->json($json);
    }

    public function show($id, Request $request){
        // Inicializamos una variable para almacenar un json nulo
        $json = null;
        // Primero obtenemos todos los registros y los almacenamos en un array
        $usuario = Usuario::where("idUsuario", $id)->get();
        // Verificamos que el array no esté vacio
        if ($usuario != "[]" && !empty($usuario)) {
            $json = array(
                'status' => 200,
                'detalle' => $usuario
            );
        }else{
            $json = array(
                'status' => 200,
                'detalle' => "Registro no encontrado."
            );
        }
        // Devolvemos la respuesta en un Json
        return response()->json($json);
    }

    public function update($id, Request $request){
        // Creamos un json nulo
        $json = null;
        // Recogemos los Datos que almacenaremos, los ingresamos a un array
        $Datos = array("NombreApellidoUsuario"=>$request->NombreApellidoUsuario,
                       "ContraseniaUsuario"=>$request->ContraseniaUsuario);

        // Validamos que los Datos no estén vacios
        if(!empty($Datos)){
            // Validamos los Datos antes de insertarlos en la base de Datos
            $validacion = Validator::make($Datos,[
                "NombreApellidoUsuario" => 'required|string|max:255',
                "ContraseniaUsuario" => 'required|string|max:255']);

            // Revisamos la validación
            if($validacion->fails()){
                // Devolvemos el mensaje que falló la validación de Datos
                $json = array(
                    "status" => 404,
                    "detalle" => "Los registros tienen errores",
                    "errores" => $validacion->errors()->all()
                );
            }else{
                // Obtendremos el Rol de la base de datos
                $ObtenerUsuario = Usuario::where("idUsuario", $id)->get();

                if(!empty($ObtenerUsuario[0])){
                    // Modificamos la información, pasamos la información contenida
                    // en el array de los datos
                    $UsuarioModificar = Usuario::where("idUsuario", $id)->update($Datos);

                    $json = array(
                        "status" => 200,
                        "detalle" => "Registro editado exitosamente"
                    );
                }else{
                    $json = array(
                        "status" => "404",
                        "detalle" => "El registro no existe."
                    );
                }
            }
        }else{
            $json = array(
                "status" => "404",
                "detalle" => "Registros incompletos"
            );
        }
        // Devolvemos la respuesta en un Json
        return response()->json($json);
    }

    public function destroy($id, Request $request){
        // Inicializamos una variable para almacenar un json nulo
        $json = null;
        // Guardemos los datos en la base de datos
        $ObtenerUsuario = Usuario::where("idUsuario", $id)->get();
        // Si el Rol no está vacío
        if(!empty($ObtenerUsuario)){
            // Eliminamos el registro
            $UsuarioEliminar = Usuario::where("idUsuario", $id)->delete();

            $json = array(
                "status" => 200,
                "detalle" => "Registro eliminado exitosamente"
            );
        }else{
            $json = array(
                "status" => "404",
                "detalle" => "El registro no existe."
            );
        }
        // Devolvemos la respuesta en un Json
        return response()->json($json);
    }

    public function encriptarDatos($contrasenia){
        // Obtenermos todos los caracteres de la contraseña que nos enviaron y lo almacenamos
        // en un array
        $Contrasenia = str_split($contrasenia);
        // Array que contendŕa los nuevos valores de la contrasenia.
        $arrayEncriptado = null;
        // A cada caracter lo moveremos 5 posiciones en la tabla ascii
        for($contador = 0; $contador < count($Contrasenia); $contador++){
            // Primero obtenemos el valor entero en ascii del caracter:
            $valorAsciiCaracter = ord($Contrasenia[$contador]);
            // Movemos el caracter 5 posiciones adelante
            $valorAsciiCaracter += 5;
            // Convertimos el ascii a caracter
            $asciiACaracter = chr($valorAsciiCaracter);
            // Guardamos el caracter en el nuevo array
            $arrayEncriptado[$contador] = $asciiACaracter;
        }
        // Unimos nuevamente todo el array de caracteres
        $ContraseniaEncriptada = implode($arrayEncriptado);
        return $ContraseniaEncriptada;
    }

    public function desencriptarDatos(Request $request){
        // Obtenermos todos los caracteres de la contraseña que nos enviaron y lo almacenamos
        // en un array
        $ContraseniaEncriptada = str_split($request->ContraseniaEncriptada);
        // Array que contendŕa los nuevos valores de la contrasenia.
        $arrayDesencriptado = null;
        // A cada caracter lo moveremos 5 posiciones en la tabla ascii
        for($contador = 0; $contador < count($ContraseniaEncriptada); $contador++){
            // Primero obtenemos el valor entero en ascii del caracter:
            $valorAsciiCaracter = ord($ContraseniaEncriptada[$contador]);
            // Movemos el caracter 5 posiciones adelante
            $valorAsciiCaracter -= 5;
            // Convertimos el ascii a caracter
            $asciiACaracter = chr($valorAsciiCaracter);
            // Guardamos el caracter en el nuevo array
            $arrayDesencriptado[$contador] = $asciiACaracter;
        }
        // Unimos nuevamente todo el array de caracteres
        $ContraseniaEncriptada = implode($arrayDesencriptado);
        // Devolveremos un Json
        $json = array(
            "status" => 200,
            "detalle" => "Contraseña desencriptada exitosamente",
            "ContraseniaUsuario" => $ContraseniaEncriptada
        );
        return response()->json($json);
    }
}
