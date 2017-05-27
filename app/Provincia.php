<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    
    protected $table = 'provincia';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function departamento(){
        return Departamento::find($this->id_departamento);
    }
}
