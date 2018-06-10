<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    
    protected $table = 'pago';
    protected $primaryKey = 'id';
    public $timestamps = false;

     public function cuenta(){ 
        return $this->hasOne("App\Cuenta","id","id_cuenta"); 
    } 
     
    public function cuota(){ 
        return $this->hasOne("App\Cuota","id","id_cuota"); 
    } 
}
