<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    
    protected $table = 'menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function grupo() {
        return Grupo::find($this->id_grupo);
    }
}
