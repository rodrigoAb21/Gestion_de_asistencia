<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion_Clientes extends Model
{
    protected $table = 'a_clientes';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'cliente_id'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
