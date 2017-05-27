<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    
    protected $table = 'contrato';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function proveedor(){
        return Proveedor::find($this->id_proveedor);
    }
    
    public function usuario(){
        return Usuario::find($this->id_usuario);
    }
}
