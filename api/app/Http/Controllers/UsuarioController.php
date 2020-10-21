<?php

namespace App\Http\Controllers;
use \Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
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
                       "llaveEncriptacion"=>$request->llaveEncriptacion,
                       "ContraseniaUsuario"=>$request->ContraseniaUsuario);

        // Validamos que los Datos no estén vacios
        if(!empty($Datos)){
            // Separamos la validación
            // Reglas
            $Reglas = [
                "NombreApellidoUsuario" => 'required|string|max:255',
                "llaveEncriptacion" => 'required|string|max:255',
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
                $usuario = new Usuario();

                // Ingresamos los datos
                $usuario->NombreApellidoUsuario = $Datos["NombreApellidoUsuario"];
                $usuario->ContraseniaUsuario = $Datos["ContraseniaUsuario"];
                $usuario->ContraseniaEncriptada = $this->encriptarDatos($Datos["ContraseniaUsuario"], $Datos["llaveEncriptacion"]);

                // Ejecutamos la acción de guardar
                $usuario->save();

                $json = array(
                    "status" => 200,
                    "detalle" => "Registro exitoso",
                    "contreseniaEncriptada" => $this->encriptarDatos($Datos["ContraseniaUsuario"], $Datos["llaveEncriptacion"])
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

    public function pruebas(){
        //print_r(openssl_get_cipher_methods());

        $contrasenia = "HolaMundo";
        $metodoDeEncriptado = "AES-256-CBC";
        $llaveSecreta = "admin123456";
        $ivSecreto = "12345678";

        $key = hash('sha256', $llaveSecreta);
        $iv = substr(hash('sha256', $ivSecreto), 0, 16);

        $contraseniaEncriptada = openssl_encrypt($contrasenia, $metodoDeEncriptado, $key,  0, $iv);

        $contraseniaDesencriptada = openssl_decrypt($contraseniaEncriptada, $metodoDeEncriptado, $key,  0, $iv);

        //$contraseniaEncriptada = Crypt::encrypt($contrasenia);
        //$contraseniaDesencriptada = Crypt::decrypt($contraseniaEncriptada);

        $json = array(
            'hash' => $key,
            'iv' => $iv,
            'contraseniaEnctriptada' => $contraseniaEncriptada,
            'contraseniaDesencriptada' => $contraseniaDesencriptada
        );

        //print_r($contraseniaEncriptada);

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

    public function encriptarDatos($contrasenia, $llaveEncriptacion){
        // Para encriptar la contraseña se utilizará el método AES-256-CBC
        $metodoDeEncriptado = "AES-256-CBC";
        // Vector de inicialización
        $ivSecreto = "12345678";
        // Para hacer uno de la clave de encriptación utilizaremos un hash que haremos a partir de la llave que el usuario envía.
        $key = hash('sha256', $llaveEncriptacion);
        // Convertiremos el venctor de inicialización en un hash y lo dividiremos en un un substring de 16 caracteres
        $iv = substr(hash('sha256', $ivSecreto), 0, 16);
        // Obtendremos la contraseña encriptada.
        $contraseniaEncriptada = openssl_encrypt($contrasenia, $metodoDeEncriptado, $key,  0, $iv);
        // Devolveremos la contraseña encriptada
        return $contraseniaEncriptada;
    }

    public function desencriptarDatos(Request $request){
        // Creamos un json nulo
        $json = null;
        // Almacenaremos los datos del request en un array
        $Datos = array("contraseniaEncriptada"=>$request->ContraseniaEncriptada,
            "llaveEncriptacion"=>$request->llaveEncriptacion);

        // Validamos que los Datos no estén vacios
        if(!empty($Datos)){
            // Separamos la validación
            // Reglas
            $Reglas = [
                "contraseniaEncriptada" => 'required|string|max:255',
                "llaveEncriptacion" => 'required|string|max:255'];

            $Mensajes = [
                "contraseniaEncriptada.required" => 'Es necesario contar con una contraseña',
                "llaveEncriptacion.required" => 'Es necesario contar con una llave.'];
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
                // Para encriptar la contraseña se utilizará el método AES-256-CBC
                $metodoDeEncriptado = "AES-256-CBC";
                // Vector de inicialización
                $ivSecreto = "12345678";
                // Para hacer uno de la clave de encriptación utilizaremos un hash que haremos a partir de la llave que el usuario envía.
                $key = hash('sha256', $Datos['llaveEncriptacion']);
                // Convertiremos el venctor de inicialización en un hash y lo dividiremos en un un substring de 16 caracteres
                $iv = substr(hash('sha256', $ivSecreto), 0, 16);
                // Obtendremos la contraseña encriptada.
                $contraseniaDesencriptada = openssl_decrypt($Datos['contraseniaEncriptada'], $metodoDeEncriptado, $key,  0, $iv);
                if($contraseniaDesencriptada === false){
                    // Devolvemos el mensaje que falló la validación de Datos
                    $json = array(
                        "status" => 404,
                        "detalle" => "La clave o contraseña encriptada no es válida",
                        "errores" => array(
                                            0 => 'La clave o contraseña encriptada no es válida'
                                          )
                    );
                }else {
                    // Devolveremos un Json con la contraseña desencriptada
                    $json = array(
                        "status" => 200,
                        "detalle" => "Contraseña desencriptada exitosamente",
                        "ContraseniaUsuario" => $contraseniaDesencriptada
                    );
                }
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
}
