<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitacoraListar extends Model
{
    
    protected $table = 'bitacora';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
