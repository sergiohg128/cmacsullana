<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaSucursal extends Model
{
    
    protected $table = 'area_sucursal';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function area(){
        return Area::find($this->id_area);
    }
    
    public function sucursal(){
        return Sucursal::find($this->id_sucursal);
    }
}
