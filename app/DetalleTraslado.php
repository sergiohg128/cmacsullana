<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleTraslado extends Model
{
    
    protected $table = 'detalle_traslado';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function traslado(){
        return Traslado::find($this->id_traslado);
    }
    
    public function producto(){
        return Producto::find($this->id_producto);
    }
}
