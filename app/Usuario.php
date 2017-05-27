<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    
    public function tipousuario() {
        return TipoUsuario::find($this->id_tipo_usuario);
    }
    
    public function proveedor(){
        return Proveedor::find($this->id_proveedor);
    }
}
