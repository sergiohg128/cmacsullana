<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sla extends Model
{
    
    protected $table = 'sla';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function tipoequipo(){
        return TipoEquipo::find($this->id_tipo_equipo);
    }
    
    public function contrato(){
        return Contrato::find($this->id_contrato);
    }
    
    public function tipoterritorio(){
        return TipoTerritorio::find($this->id_tipo_territorio);
    }
}
