<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    
    protected $table = 'proveedor';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function distrito(){
        return Distrito::find($this->id_distrito);
    }
    
    public function provincia(){
        return Provincia::find(Distrito::find($this->id_distrito)->id_provincia);
    }
    
    public function departamento(){
        return Departamento::find(Provincia::find(Distrito::find($this->id_distrito)->id_provincia)->id_departamento);
    }
    
    public function pais(){
        return Pais::find($this->id_pais);
    }
}
