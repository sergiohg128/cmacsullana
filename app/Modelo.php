<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    
    protected $table = 'modelo';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function marca() {
        return Marca::find($this->id_marca);
    }
    
    public function tipoequipo(){
        return TipoEquipo::find($this->id_tipo_equipo);
    }
}
