<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\publicaciones;

class PublicacionesController extends Controller
{
    public function index(){
      $publicaciones = publicaciones::all()->load('user');
      return response()->json(array(
        'publicaciones' => $publicaciones,
        'status' => 'success'
      ),200);
    }

    public function verPublicacion($kIdPublicacion){
      $publicaciones = publicaciones::find($kIdPublicacion)->load('user');
      return response()->json(array(
        'publicaciones' => $publicaciones,
        'status' => 'success'
      ),200);
    }

    public function agregarPublicacion (Request $request){
      $hash = $request->header('Authorization', null);
      $jwtAuth = new JwtAuth();
      $checkToken = $jwtAuth->checkToken($hash);

      if($checkToken){
        //Recoger datos por POST
        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);

        //Consegir el usuario identificado
        $user = $jwtAuth->checkToken($hash,true);

        //Validacion de parametros
        $validate = \Validator::make($params_array,[
          'titulo' => 'required|min:5',
          'contenido' => 'required|min:10',
          'estatus' => 'required'
        ]);

          if($validate->fails()){
              return   response()->json($validate->errors(),400);
            }
        //Publicar comentario
        $publicacion = new publicaciones();
        $publicacion->fkIdUsuario = $user->sub;
        $publicacion->titulo = $params->titulo;
        $publicacion->contenido = $params->contenido;
        $publicacion->estatus = $params->estatus;
        $publicacion->save();
        $data = array(
          'publicacion' => $publicacion,
          'status' => 'succes',
          'code' => 200,
        );
      }
      else {
        $data = array(
        'message' => 'Error al crear la publicacion',
        'status' => 'error',
        'code'=> 300  ,
      );
      }
      return response()->json($data,200);
    }

    public function actualizarPublicacion($id, Request $request){
      $hash = $request->header('Authorization', null);
      $jwtAuth = new JwtAuth();
      $checkToken = $jwtAuth->checkToken($hash);

      if($checkToken){
        //Actualizar el registro

        //Recoger parametros por PDOStatement
        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);
        //Validar los datos
        $validate = \Validator::make($params_array,[
          'titulo' => 'required|min:5',
          'contenido' => 'required|min:10',
          'estatus' => 'required'
        ]);

          if($validate->fails()){
              return   response()->json($validate->errors(),400);
            }

        //Actualizar el registro
        $publicacion = publicaciones::where('kIdPublicacion',$id)->update($params_array);
        $data = array(
        'publicacion' => $params,
        'status' => 'success',
        'code'=> 300,
      );
        }
        else {
          $data = array(
          'message' => 'Error al crear la publicacion, necesitas logearte',
          'status' => 'error',
          'code'=> 300  ,
        );
        }
        return response()->json($data,200);
    }

    public function deletePublicacion($id, Request $request){
      $hash = $request->header('Authorization', null);
      $jwtAuth = new JwtAuth();
      $checkToken = $jwtAuth->checkToken($hash);

      if($checkToken){
        //Comprobar que existe el registros
        $publicacion = publicaciones::find($id);
        //Borrarlo
        $publicacion->delete();
        //Devolverlo
        $data = array(
          'publicacion' => $publicacion,
          'status' => 'success',
          'code' => 200
        );
      }
      else {
        $data = array(
        'message' => 'Error al crear la publicacion, necesitas logearte',
        'status' => 'error',
        'code'=> 300  ,
      );
      }
      return response()->json($data,200);
    }

    public function bajaPublicacion($id, Request $request){
      $hash = $request->header('Authorization', null);
      $jwtAuth = new JwtAuth();
      $checkToken = $jwtAuth->checkToken($hash);

      if($checkToken){
        //Actualizar el registro

        //Recoger parametros por PDOStatement
        $json = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);
        //Validar los datos
        $validate = \Validator::make($params_array,[
          'estatus' => 'required',
          'fechaBaja' => 'required'
        ]);

          if($validate->fails()){
              return   response()->json($validate->errors(),400);
            }

        //Actualizar el registro
        $publicacion = publicaciones::where('kIdPublicacion',$id)->update($params_array);
        $data = array(
        'publicacion' => $params,
        'status' => 'success',
        'code'=> 300,
      );
        }
        else {
          $data = array(
          'message' => 'Error al crear la publicacion, necesitas logearte',
          'status' => 'error',
          'code'=> 300  ,
        );
        }
        return response()->json($data,200);
    }
}
