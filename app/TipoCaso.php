<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCaso extends Model
{
    
    protected $table = 'tipo_caso';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
