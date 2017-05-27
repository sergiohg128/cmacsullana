<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    
    protected $table = 'caso';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function producto(){
        return Producto::find($this->id_producto);
    }
    
    public function tecnico(){
        return Tecnico::find($this->id_tecnico);
    }
    
    public function tipocaso(){
        return TipoCaso::find($this->id_tipo_caso);
    }
    
    public function tiposolucion(){
        return TipoSolucion::find($this->id_tipo_solucion);
    }
    
    public function sucursal(){
        return Sucursal::find($this->id_sucursal);
    }
    
    public function traslado(){
        return Traslado::find($this->id_traslado);
    }
}
