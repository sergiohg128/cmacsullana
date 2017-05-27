<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    
    protected $table = 'sucursal';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function zona(){
        return Zona::find($this->id_zona);
    }
    
    public function distrito(){
        return Distrito::find($this->id_distrito);
    }
    
    public function provincia(){
        return Provincia::find(Distrito::find($this->id_distrito)->id_provincia);
    }
    
    public function departamento(){
        return Departamento::find(Provincia::find(Distrito::find($this->id_distrito)->id_provincia)->id_departamento);
    }
    
    public function ubicacion(){
        $distrito = Distrito::find($this->id_distrito);
        $provincia = Provincia::find($distrito->id_provincia);
        $departamento = Departamento::find($provincia->id_departamento);
        return $departamento->nombre.'-'.$provincia->nombre.'-'.$distrito->nombre;
    }
    
    public function tipoterritorio(){
        return TipoTerritorio::find($this->id_tipo_territorio);
    }
    
    public function tiposucursal(){
        return TipoSucursal::find($this->id_tipo_sucursal);
    }
}
