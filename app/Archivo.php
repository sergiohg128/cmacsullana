<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    
    protected $table = 'archivo';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
