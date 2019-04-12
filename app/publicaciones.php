<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publicaciones extends Model
{
    protected $table = 'publicaciones';
    protected $primaryKey = 'kIdPublicacion';
    const CREATED_AT = 'FechaAlta';
    const UPDATED_AT = 'FechaActualiza';
    //public $timestamps = false;  //Agregar para que no pida insertar los campos de CREATED_AD Y UPDATED_AD
    // Relacion
    public function user(){
    	return $this->belongsTo('App\User', 'fkIdUsuario');
    }

}
