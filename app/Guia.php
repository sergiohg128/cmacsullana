<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    
    protected $table = 'guia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function contrato(){
        return Contrato::find($this->id_contrato);
    }
    
    public function sucursal(){
        return Sucursal::find($this->id_sucursal);
    }
}
