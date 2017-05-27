<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
    
    protected $table = 'traslado';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function motivotraslado(){
        return MotivoTraslado::find($this->id_motivo_traslado);
    }
    
    public function sucursalenvia(){
        return Sucursal::find($this->id_origen);
    }
    
    public function sucursalrecibe(){
        return Sucursal::find($this->id_destino);
    }
}
