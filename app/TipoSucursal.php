<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoSucursal extends Model
{
    
    protected $table = 'tipo_sucursal';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
