<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    
    protected $table = 'tecnico';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function proveedor(){
        $proveedor =  Proveedor::find($this->id_proveedor);
        if($proveedor==null){
            $proveedor = new Proveedor();
            $proveedor->id = 0;
            $proveedor->razon = "TÉCNICO PROPIO";
        }
        return $proveedor;
    }
}
