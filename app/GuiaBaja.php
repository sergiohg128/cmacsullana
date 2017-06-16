<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaBaja extends Model
{
    
    protected $table = 'guiabaja';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function sucursal(){
        return Sucursal::find($this->id_sucursal);
    }
}
