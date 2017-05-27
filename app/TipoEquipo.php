<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEquipo extends Model
{
    
    protected $table = 'tipo_equipo';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
