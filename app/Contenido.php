<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contenido extends Model
{
    
    protected $table = 'contenido';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
