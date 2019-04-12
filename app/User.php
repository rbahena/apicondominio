<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //Las variables que estan entre comillas, deber ser nombradas igual que el campo que ocupa en la BD.
    protected $table = 'Usuarios';
    protected $primaryKey = 'kIdUsuario';
    const username = 'Username';
    const name = 'Nombre';
    const lastName = 'Apellidos';
    const email = 'Correo';
    const password = 'Contrasena';
    const CREATED_AT = 'FechaAlta';
    const UPDATED_AT = 'FechaRegistro';
    const status = 'Estatus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //aqui, agregue los campos que tengo en mi BD, los anote en ingles y arriba hago la referencia al campo de BD
        // los datos CREATED_AT y UPDATED_AT ya existen por defecto.
       'username','name','lastName','email','password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
