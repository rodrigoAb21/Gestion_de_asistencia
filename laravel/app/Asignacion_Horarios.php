<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion_Horarios extends Model
{
    protected $table = 'a_horarios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'horario_id',
        'user_id'
    ];

    public function horario(){
        return $this->belongsTo(Horario::class);
    }

}
