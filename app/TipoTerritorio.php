<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTerritorio extends Model
{
    
    protected $table = 'tipo_territorio';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
