<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    
    protected $table = 'distrito';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function provincia(){
        return Provincia::find($this->id_provincia);
    }
    
    public function departamento(){
        return Departamento::find(Provincia::find($this->id_provincia)->id_departamento);
    }
}
