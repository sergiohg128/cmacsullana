<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleGuiaBaja extends Model
{
    
    protected $table = 'detalle_guiabaja';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function producto(){
        return Producto::find($this->id_producto);
    }
    
    public function guiabaja(){
        return GuiaBaja::find($this->id_guiabaja);
    }
}
