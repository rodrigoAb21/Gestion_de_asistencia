<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'huella',
        'foto',
        'direccion',
        'telefono',
        'email',
        'password',
        'rol_id',
        'ubicacion_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function a_horarios(){
        return $this->hasMany(Asignacion_Horarios::class, 'user_id');
    }
}
