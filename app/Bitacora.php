<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    
    protected $table = 'bitacora';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    
    function __construct($tabla,$tipo,$accion,$id_usuario){
        $this->tabla = $tabla;
        $this->tipo = $tipo;
        $this->accion = $accion;
        $this->id_usuario = $id_usuario;
        $this->save();
    }
}
