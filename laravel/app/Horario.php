<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horario';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'turno',
        'visible'
    ];

    public function dias(){
        return $this->hasMany(Dia::class);
    }
}
