<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
    
    protected $table = 'universidad';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
