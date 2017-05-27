<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCaso extends Model
{
    
    protected $table = 'detalle_caso';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function caso(){
        return Caso::find($this->id_caso);
    }
}
