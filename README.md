# Algoritmo de encriptacion AES  👩‍💻


## Base de datos  🛢 

```sql
DROP DATABASE IF EXISTS bd_algoritmo;

--crear base de datos
CREATE DATABASE bd_algoritmo;

USE bd_algoritmo;

--crear tabla usuario
CREATE TABLE usuarios(
    idUsuario               TINYINT             NOT NULL                PRIMARY KEY             AUTO_INCREMENT,
    NombreApellidoUsuario   VARCHAR(50)         NOT NULL,
    ContraseniaUsuario      VARCHAR(30)         NOT NULL,
    ContraseniaEncriptada   VARCHAR(50)         NOT NULL,
    created_at				TIMESTAMP			NULL,
	updated_at				TIMESTAMP			NULL
)ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_spanish_ci;

```

## Creacion de la api  🔐 

1. Para crear la api necesitamos lo siguiente:

    1. Composer
    2. Lumen
    3. Xampp
    4. Editor de texto

2. para instalar lumen utilizamos el siguiente comando:

```shell
coloca comando 
```
3. clonamos el archivo .env.example y le colocamos .env y modificamos la cadena de conexion.

```sql
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=bd_algoritmo
DB_USERNAME=root
DB_PASSWORD=
```

## Controladores 

4. Luego de instalar el framewor de lumen, se crearan la estructura de nuestro proyecto, ahora devemos ir a la carpeta de api/app/Http/Controllers.

    1. creamos el contralor Encriptar

```php
<?php

namespace App\Http\Controllers;
use \Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class EncriptarController extends BaseController
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

```


    2. creamos el controlador Desencriptar

```php
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

```

    3. creamos el contrador Usuario
        1. creamos la funcion index

```php
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
```
        2. Creamos la funcion store, con esta funcion obtenemos los datos que el usuario ingresa.

 ```php
 public function store(Request $request){ 
     ------
 ```           

        3. Creamos la funcion show, con esta funcion alamacenamos los datos del usuario

 ```php
 public function show($id, Request $request){
     ------
 ``` 

         4. Creamos la funcion update, con esta funcion se actualiza la informacion del usuario

 ```php
public function update($id, Request $request){
     ------
 ```  
        5. Creamos la funcion encriptarDatos, con esta funcion procedemos a encriptar la contraseña proporsionada por el usuario    
 ```php
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

 ```
 
            6. Creamos la funcion desencriptarDatos, con esta funcion procedemos a encriptar la contraseña proporsionada por el usuario  

 ```php
    public function desencriptarDatos(Request $request){
        // Almacenaremos los datos del request en variables locales
        $contraseniaEncriptada = $request->ContraseniaEncriptada;
        $llaveEncriptacion = $request->llaveEncriptacion;
        // Para encriptar la contraseña se utilizará el método AES-256-CBC
        $metodoDeEncriptado = "AES-256-CBC";
        // Vector de inicialización
        $ivSecreto = "12345678";
        // Para hacer uno de la clave de encriptación utilizaremos un hash que haremos a partir de la llave que el usuario envía.
        $key = hash('sha256', $llaveEncriptacion);
        // Convertiremos el venctor de inicialización en un hash y lo dividiremos en un un substring de 16 caracteres
        $iv = substr(hash('sha256', $ivSecreto), 0, 16);
        // Obtendremos la contraseña encriptada.
        $contraseniaDesencriptada = openssl_decrypt($contraseniaEncriptada, $metodoDeEncriptado, $key,  0, $iv);
        // Devolveremos un Json con la contraseña desencriptada
        $json = array(
            "status" => 200,
            "detalle" => "Contraseña desencriptada exitosamente",
            "ContraseniaUsuario" => $contraseniaDesencriptada
        );
        return response()->json($json);
    }    
 ```

## Model

1. creamos el model Usuario e indicamos el nombre de la tabla y la llave primario, dado que esta informacion la utilizamos en el controlador Usuario.

 ```php
<?php


namespace App\Models;
use \Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "usuarios";
    protected $primaryKey = "idUsuario";
}

```
# Configuracion de la interfaz de usuario (app)


