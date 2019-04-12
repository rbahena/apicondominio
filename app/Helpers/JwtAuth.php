<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth{

   public $key;

   public function __construct(){
      $this->key='Esta-es-mi-clave-secreta';
   }

   public function singUp($email, $password, $getToken = null)
   {
      $user = User::where(
         array(
         'Correo' => $email,
         'Contrasena' => $password
         ))->first();

      $singup = false;
      if(is_object($user)){
         $singup = true;
      }

      if( $singup )
      {
         //Generar el token y devolverlo
         $token = array(
         'sub'=>$user->kIdUsuario,
         'email'=>$user->Correo,
         'name'=>$user->Nombre,
         'surname'=>$user->Username,
         'iat'=>time(),
         'exp'=>time() + (7 * 24 * 60 * 60)
      );
      $jwt = JWT::encode($token, $this->key , 'HS256');
      $decoded = JWT::decode($jwt,$this->key, array('HS256'));

      if(is_null($getToken)){
         return $jwt;
      }
      else{
         return $decoded;
      }
      }
      else
      {
        $data = array(
                'status'=>'error',
                'code' => 400,
                'message'=> 'Revisar credenciales!!!'
                        );
         //Devolver un error
         return $data;
      }

   }


   public function checkToken($jwt, $getIdentity = false)
   {
      $auth = false;

      try{
         $decoded = JWT::decode($jwt, $this->key, array('HS256'));
      }
      catch(\UnexpectedValueException $e){
         $auth = false;
      }
      catch(\DomainException $e){
         $auth = false;
      }

      if(isset($decoded) && is_object($decoded) && isset($decoded->sub)){
         $auth = true;
      }
      else{
         $auth = false;
      }

      if($getIdentity){
         return $decoded;
      }
      return $auth;
   }

}
