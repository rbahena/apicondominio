<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Helpers\JwtAuth;

class UserController extends Controller
{
    public function register(Request $request){
        //Recoger POST
        $json = $request->input('json',null);
        $params = json_decode($json);
        $surname  = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
        $name  = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $lastName  = (!is_null($json) && isset($params->lastName)) ? $params->lastName : null;
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password  = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $status = (!is_null($json) && isset($params->status)) ? $params->status : null;

        if(!is_null($email) && !is_null($password) && !is_null($name))
        {
            //Crear el usuario
            $pwd = hash('sha256',$password);
            $user = new User();
            $user-> Username = $surname;
            $user-> Nombre = $name;
            $user-> Apellidos = $lastName;
            $user-> Correo = $email;
            $user-> Contrasena = $pwd;
            $user-> Estatus = $status;

            //Validar usuario duplicado
            $isset_user = User::where('correo', '=', $email)->count();
            if($isset_user == 0){
            //Guarda usuario
            $user -> save();
            $data = array(
                'status'=>'succes',
                'code' => 200,
                'message'=> 'Usuario registrado correctamente'
                 );
            }
            else{

            $data = array(
                'status'=>'error',
                'code' => 400,
                'message'=> 'El usuario ya existe'
                 );
            }
        }
        else
        {
            $data = array(
                    'status'=>'error',
                    'code' => 4001,
                    'message'=> $json
                            );
        }
        return response()->json($data,200);
    }

 	public function login(Request $request){
        $jwtAuth = new JwtAuth();

        //Recibir post
        $json = $request->input('json', null);
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->gettoken)) ? $params->gettoken : null;

        //Cifrar la password
        $pwd = hash('sha256',$password);
        if(!is_null($email) && !is_null($password) && ($getToken == null || $getToken == 'false')){
            $signup = $jwtAuth->singUp($email,$pwd);
        }
        else if($getToken != null){
          $signup = $jwtAuth->singUp($email, $pwd, $getToken);
        }
        else {
          $signup = array(
          'status' => 'error',
          'code' => 400,
          'message' => 'Error al enviar los datos.'
        );
        }
          return response()->json($signup,200);
    }
}
