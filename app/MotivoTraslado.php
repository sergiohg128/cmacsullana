<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotivoTraslado extends Model
{
    
    protected $table = 'motivo_traslado';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}