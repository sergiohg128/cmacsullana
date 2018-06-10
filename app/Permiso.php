<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    
    protected $table = 'permiso';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
