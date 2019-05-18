<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $table = 'dia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'horario_id',
        'nombre',
        'entrada',
        'salida'
    ];
}
