<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    
    protected $table = 'grupo';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
